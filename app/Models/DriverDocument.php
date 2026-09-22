<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * The current uploaded file for one (driver, document type).
 *
 * "Not Uploaded" is the absence of a row; "Expired" is derived from
 * expiry_date (see effectiveStatus()) so it can never go stale.
 */
class DriverDocument extends Model
{
    public const STATUS_NOT_UPLOADED = 'not_uploaded';
    public const STATUS_UPLOADED     = 'uploaded';
    public const STATUS_UNDER_REVIEW = 'under_review';
    public const STATUS_APPROVED     = 'approved';
    public const STATUS_REJECTED     = 'rejected';
    public const STATUS_EXPIRED      = 'expired';

    public const STATUS_LABELS = [
        self::STATUS_NOT_UPLOADED => 'Not Uploaded',
        self::STATUS_UPLOADED     => 'Uploaded',
        self::STATUS_UNDER_REVIEW => 'Under Review',
        self::STATUS_APPROVED     => 'Approved',
        self::STATUS_REJECTED     => 'Rejected',
        self::STATUS_EXPIRED      => 'Expired',
    ];

    protected $fillable = [
        'user_id', 'type', 'original_name', 'path', 'thumb_path', 'mime', 'extension',
        'size', 'checksum', 'status', 'issue_date', 'expiry_date', 'uploaded_at',
        'uploaded_by', 'reviewed_by', 'reviewed_at', 'rejection_reason', 'rejected_at',
    ];

    // Storage internals never leave the server, even via toArray()/toJson().
    protected $hidden = ['path', 'thumb_path', 'checksum'];

    protected $casts = [
        'size'        => 'integer',
        'issue_date'  => 'date',
        'expiry_date' => 'date',
        'uploaded_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $doc) {
            $doc->uuid ??= (string) Str::uuid();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(DriverDocumentReview::class)->latest('id');
    }

    /** Config for this document's type (label, expiry rules, ...). */
    public function definition(): array
    {
        return config("driver_documents.types.{$this->type}", []);
    }

    /** The status shown to people: stored status, unless the document has expired. */
    public function effectiveStatus(): string
    {
        $expirable = [self::STATUS_UPLOADED, self::STATUS_UNDER_REVIEW, self::STATUS_APPROVED];

        if (in_array($this->status, $expirable, true) && $this->expiry_date && $this->expiry_date->lt(today())) {
            return self::STATUS_EXPIRED;
        }

        return $this->status;
    }

    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->effectiveStatus()] ?? ucfirst($this->status);
    }

    /**
     * Expiry warning, or null when the document has no expiry date.
     *
     * @return array{state:string,days:int,label:string}|null
     *   state: valid | warning | soon | expired
     */
    public function expiryInfo(): ?array
    {
        if (!$this->expiry_date) {
            return null;
        }

        $days = (int) today()->diffInDays($this->expiry_date, false);
        $soon = (int) config('driver_documents.expiry_soon_days', 14);
        $warn = (int) config('driver_documents.expiry_warning_days', 30);

        if ($days < 0) {
            $ago = abs($days);
            return ['state' => 'expired', 'days' => $days, 'label' => $ago === 1 ? 'Expired yesterday' : "Expired {$ago} days ago"];
        }
        if ($days === 0) {
            return ['state' => 'soon', 'days' => 0, 'label' => 'Expires today'];
        }
        if ($days <= $soon) {
            return ['state' => 'soon', 'days' => $days, 'label' => 'Expires soon — in ' . $days . ($days === 1 ? ' day' : ' days')];
        }
        if ($days <= $warn) {
            return ['state' => 'warning', 'days' => $days, 'label' => "Expires in {$days} days"];
        }

        return ['state' => 'valid', 'days' => $days, 'label' => 'Valid until ' . $this->expiry_date->format('d M Y')];
    }

    public function isImage(): bool
    {
        return in_array($this->mime, ['image/jpeg', 'image/png'], true);
    }

    public function isPdf(): bool
    {
        return $this->mime === 'application/pdf';
    }

    public function fileTypeLabel(): string
    {
        return strtoupper($this->extension === 'jpeg' ? 'jpg' : $this->extension);
    }

    public function humanSize(): string
    {
        $bytes = (int) $this->size;

        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }

        return max(1, (int) round($bytes / 1024)) . ' KB';
    }
}
