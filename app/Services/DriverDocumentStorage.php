<?php

namespace App\Services;

use finfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Stores driver documents on the private disk, encrypted at rest.
 *
 * - The file's type is decided by sniffing its content, never by the client's
 *   filename or claimed MIME type.
 * - Stored names are random; the client's filename is kept only as display text.
 * - Bytes are AES-encrypted with the app key, so a leaked disk/backup is not a
 *   leaked pile of licences.
 */
class DriverDocumentStorage
{
    private const MIME_TO_EXT = [
        'application/pdf' => 'pdf',
        'image/jpeg'      => 'jpg',
        'image/png'       => 'png',
    ];

    private const THUMB_MAX_EDGE = 320;

    public function disk()
    {
        return Storage::disk(config('driver_documents.disk'));
    }

    /**
     * Encrypt and store an uploaded file.
     *
     * @return array{path:string,thumb_path:?string,mime:string,extension:string,size:int,checksum:string,original_name:string}
     */
    public function store(UploadedFile $file, int $driverId): array
    {
        $bytes = file_get_contents($file->getRealPath());
        if ($bytes === false || $bytes === '') {
            throw new RuntimeException('The uploaded file could not be read.');
        }

        $mime = (new finfo(FILEINFO_MIME_TYPE))->buffer($bytes);
        if (!isset(self::MIME_TO_EXT[$mime])) {
            throw new RuntimeException('Unsupported file type.');
        }

        $ext  = self::MIME_TO_EXT[$mime];
        $base = $driverId . '/' . Str::uuid();

        $path = "{$base}.{$ext}.enc";
        $this->disk()->put($path, Crypt::encryptString($bytes));

        $thumbPath = null;
        if (str_starts_with($mime, 'image/') && ($thumb = $this->makeThumbnail($bytes, $mime))) {
            $thumbPath = "{$base}.thumb.enc";
            $this->disk()->put($thumbPath, Crypt::encryptString($thumb));
        }

        return [
            'path'          => $path,
            'thumb_path'    => $thumbPath,
            'mime'          => $mime,
            'extension'     => $ext,
            'size'          => strlen($bytes),
            'checksum'      => hash('sha256', $bytes),
            'original_name' => $this->safeName($file->getClientOriginalName(), $ext),
        ];
    }

    /** Decrypted file bytes, or null if the file is missing / unreadable. */
    public function read(?string $path): ?string
    {
        if (!$path || !$this->disk()->exists($path)) {
            return null;
        }

        try {
            return Crypt::decryptString($this->disk()->get($path));
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }

    public function delete(?string ...$paths): void
    {
        foreach (array_filter($paths) as $path) {
            $this->disk()->delete($path);
        }
    }

    /**
     * Keep the client's filename for display only: strip paths and control
     * characters, bound the length, and make sure it ends with the real extension.
     */
    private function safeName(?string $name, string $ext): string
    {
        $name = basename(str_replace('\\', '/', (string) $name));
        $name = preg_replace('/[\x00-\x1F\x7F<>:"|?*]+/u', '', $name);
        $stem = pathinfo($name, PATHINFO_FILENAME);
        $stem = Str::limit(trim($stem), 100, '');

        return ($stem !== '' ? $stem : 'document') . '.' . $ext;
    }

    /** Small JPEG for the upload card; null if the image can't safely be decoded. */
    private function makeThumbnail(string $bytes, string $mime): ?string
    {
        if (!function_exists('imagecreatefromstring')) {
            return null;
        }

        $info = @getimagesizefromstring($bytes);
        if (!$info || $info[0] < 1 || $info[1] < 1) {
            return null;
        }
        [$w, $h] = $info;

        // GD needs roughly 5 bytes/pixel while decoding - skip rather than
        // risk a fatal out-of-memory on a huge photo.
        if (!$this->hasMemoryFor($w * $h * 5)) {
            return null;
        }

        $src = @imagecreatefromstring($bytes);
        if (!$src) {
            return null;
        }

        if ($mime === 'image/jpeg' && ($angle = $this->safeJpegRotation($bytes))) {
            $rotated = imagerotate($src, $angle, 0);
            if ($rotated) {
                imagedestroy($src);
                $src = $rotated;
                [$w, $h] = [imagesx($src), imagesy($src)];
            }
        }

        $scale = min(1, self::THUMB_MAX_EDGE / max($w, $h));
        $tw = max(1, (int) round($w * $scale));
        $th = max(1, (int) round($h * $scale));

        $thumb = imagecreatetruecolor($tw, $th);
        imagefill($thumb, 0, 0, imagecolorallocate($thumb, 255, 255, 255)); // flatten PNG transparency
        imagecopyresampled($thumb, $src, 0, 0, 0, 0, $tw, $th, $w, $h);

        ob_start();
        imagejpeg($thumb, null, 78);
        $out = ob_get_clean();

        imagedestroy($src);
        imagedestroy($thumb);

        return $out ?: null;
    }

    private function hasMemoryFor(int $bytes): bool
    {
        $limit = ini_get('memory_limit');
        if ($limit === '-1') {
            return true;
        }

        $unit  = strtolower(substr($limit, -1));
        $value = (int) $limit;
        $limitBytes = match ($unit) {
            'g' => $value * 1073741824,
            'm' => $value * 1048576,
            'k' => $value * 1024,
            default => $value,
        };

        return ($limitBytes - memory_get_usage(true)) > ($bytes * 1.5);
    }

    /** A malformed EXIF block must never fail the upload - just skip rotation. */
    private function safeJpegRotation(string $bytes): int
    {
        try {
            return $this->jpegRotation($bytes);
        } catch (\Throwable) {
            return 0;
        }
    }

    /**
     * Degrees to rotate (GD's counter-clockwise convention) to undo a phone
     * photo's EXIF orientation. Reads the tag by hand so it doesn't depend on
     * the optional exif extension. 0 when absent or unreadable.
     */
    private function jpegRotation(string $bytes): int
    {
        if (substr($bytes, 0, 2) !== "\xFF\xD8") {
            return 0;
        }

        $offset = 2;
        $length = strlen($bytes);

        while ($offset + 4 < $length && $bytes[$offset] === "\xFF") {
            $marker  = ord($bytes[$offset + 1]);
            $segSize = unpack('n', substr($bytes, $offset + 2, 2))[1];

            if ($marker === 0xE1 && substr($bytes, $offset + 4, 6) === "Exif\0\0") {
                $tiff   = $offset + 10;
                $little = substr($bytes, $tiff, 2) === 'II';
                $u16 = fn (int $pos) => unpack($little ? 'v' : 'n', substr($bytes, $pos, 2))[1] ?? 0;
                $u32 = fn (int $pos) => unpack($little ? 'V' : 'N', substr($bytes, $pos, 4))[1] ?? 0;

                $ifd     = $tiff + $u32($tiff + 4);
                $entries = $u16($ifd);

                for ($i = 0; $i < $entries && $i < 64; $i++) {
                    $entry = $ifd + 2 + ($i * 12);
                    if ($u16($entry) === 0x0112) {
                        return match ($u16($entry + 8)) {
                            3 => 180,
                            6 => -90,   // rotate 90° clockwise
                            8 => 90,    // rotate 90° counter-clockwise
                            default => 0,
                        };
                    }
                }
                return 0;
            }

            if ($marker === 0xDA) { // start of scan - no more headers
                return 0;
            }
            $offset += 2 + $segSize;
        }

        return 0;
    }
}
