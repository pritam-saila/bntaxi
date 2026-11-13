<?php

namespace App\Services;

use App\Exceptions\DriverDocumentException;
use App\Mail\DriverDocumentUploadedMail;
use App\Models\Book;
use App\Models\DriverDocument;
use App\Models\DriverDocumentReview;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Every state change to a driver document goes through here, so the audit
 * trail (driver_document_reviews) can never be skipped.
 */
class DriverDocumentService
{
    public function __construct(private DriverDocumentStorage $storage)
    {
    }

    public static function roleOf(User $user): string
    {
        return (int) $user->getRawOriginal('type') === 1 ? 'admin' : 'driver';
    }

    /**
     * Upload a new document, or replace the existing one for this type.
     *
     * A replacement resets the review: status goes back to "uploaded", and any
     * rejection is cleared (it's a new file). Replacing an *approved* document
     * needs an explicit $confirmReplace.
     *
     * $issueDate/$expiryDate are the driver's own reading of the physical
     * document, given alongside the file. Only stored for a type that's
     * configured to have that date (see config/driver_documents.php) - a
     * value submitted for a type that doesn't use it is silently dropped,
     * same as the admin review form already treats it. They're a starting
     * point only - the admin review form still shows and can correct them
     * before approving.
     */
    public function upload(User $driver, string $type, UploadedFile $file, User $actor, bool $confirmReplace = false, ?string $issueDate = null, ?string $expiryDate = null): DriverDocument
    {
        $existing = DriverDocument::where('user_id', $driver->id)->where('type', $type)->first();

        $this->guardReplace($existing, $confirmReplace);

        $meta = $this->storage->store($file, $driver->id);

        try {
            $doc = DB::transaction(function () use ($driver, $type, $meta, $actor, $confirmReplace, $issueDate, $expiryDate) {
                $current = DriverDocument::where('user_id', $driver->id)->where('type', $type)->lockForUpdate()->first();
                $this->guardReplace($current, $confirmReplace);

                $fromStatus = $current?->status;
                $def        = config("driver_documents.types.{$type}", []);

                $attributes = $meta + [
                    'status'           => DriverDocument::STATUS_UPLOADED,
                    'issue_date'       => !empty($def['has_issue_date']) ? ($issueDate ?: null) : null,
                    'expiry_date'      => !empty($def['has_expiry']) ? ($expiryDate ?: null) : null,
                    'uploaded_at'      => now(),
                    'uploaded_by'      => $actor->id,
                    'reviewed_by'      => null,
                    'reviewed_at'      => null,
                    'rejection_reason' => null,
                    'rejected_at'      => null,
                ];

                if ($current) {
                    $current->update($attributes);
                    $doc = $current;
                } else {
                    $doc = DriverDocument::create($attributes + ['user_id' => $driver->id, 'type' => $type]);
                }

                $this->log($doc, $actor, $current ? 'replaced' : 'uploaded', $fromStatus, DriverDocument::STATUS_UPLOADED);

                return $doc;
            });
        } catch (\Throwable $e) {
            $this->storage->delete($meta['path'], $meta['thumb_path']);
            throw $e;
        }

        // Only once the new row is safely committed do we drop the old file.
        if ($existing) {
            $this->storage->delete($existing->path, $existing->thumb_path);
        }

        // Only when the driver uploaded it themselves - an admin uploading on a
        // driver's behalf doesn't need to be told about their own action. Never
        // let a mail problem get in the way of the upload actually succeeding.
        if (self::roleOf($actor) === 'driver') {
            try {
                Mail::to(Book::adminNotificationRecipients())->send(new DriverDocumentUploadedMail($doc, (bool) $existing));
            } catch (\Throwable $e) {
                Log::error('driver.document_uploaded_mail_failed', ['document' => $doc->uuid, 'error' => $e->getMessage()]);
            }
        }

        return $doc;
    }

    /**
     * Driver self-service: correct the issue/expiry date without re-uploading
     * the file (e.g. fixing a typo). Same "can't touch an approved document"
     * guard as delete() - once approved, a date change needs a fresh upload via
     * Replace, so the approval can't quietly drift out of sync with the file.
     */
    public function updateDates(DriverDocument $doc, User $actor, ?string $issueDate, ?string $expiryDate): DriverDocument
    {
        if ($doc->effectiveStatus() === DriverDocument::STATUS_APPROVED && self::roleOf($actor) !== 'admin') {
            throw new DriverDocumentException(
                'approved_locked',
                'This document is approved, so its dates can\'t be changed here. Use "Replace Document" to upload a new version.',
                403
            );
        }

        return DB::transaction(function () use ($doc, $actor, $issueDate, $expiryDate) {
            $def = $doc->definition();
            $from = $doc->status;

            if (!empty($def['has_issue_date'])) {
                $doc->issue_date = $issueDate ?: null;
            }
            if (!empty($def['has_expiry'])) {
                $doc->expiry_date = $expiryDate ?: null;
            }
            $doc->save();

            $this->log($doc, $actor, 'dates_updated', $from, $doc->status, null, null);

            return $doc;
        });
    }

    /** Drivers can't delete an approved document (they must use Replace); admins can. */
    public function delete(DriverDocument $doc, User $actor): void
    {
        if ($doc->effectiveStatus() === DriverDocument::STATUS_APPROVED && self::roleOf($actor) !== 'admin') {
            throw new DriverDocumentException(
                'approved_locked',
                'This document is approved, so it can\'t be deleted. Use "Replace Document" to upload a new version.',
                403
            );
        }

        [$path, $thumb] = [$doc->path, $doc->thumb_path];

        DB::transaction(function () use ($doc, $actor) {
            $this->log($doc, $actor, 'deleted', $doc->status, DriverDocument::STATUS_NOT_UPLOADED);
            $doc->delete();
        });

        $this->storage->delete($path, $thumb);
    }

    /**
     * Admin review action.
     *
     * @param array{action:string,reason?:?string,note?:?string,issue_date?:?string,expiry_date?:?string} $data
     *   action: approve | reject | reupload | dates | note
     */
    public function review(DriverDocument $doc, User $admin, array $data): DriverDocument
    {
        $action = $data['action'];
        $reason = $this->clean($data['reason'] ?? null);
        $note   = $this->clean($data['note'] ?? null);

        return DB::transaction(function () use ($doc, $admin, $action, $reason, $note, $data) {
            $from = $doc->status;
            $def  = $doc->definition();

            // Dates only mean something for document types configured to have them.
            if (in_array($action, ['approve', 'dates'], true)) {
                if (!empty($def['has_issue_date'])) {
                    $doc->issue_date = $data['issue_date'] ?? null ?: null;
                }
                if (!empty($def['has_expiry'])) {
                    $doc->expiry_date = $data['expiry_date'] ?? null ?: null;
                }
            }

            switch ($action) {
                case 'approve':
                    $doc->status = DriverDocument::STATUS_APPROVED;
                    $doc->rejection_reason = null;
                    $doc->rejected_at = null;
                    $this->stampReview($doc, $admin);
                    $logAction = 'approved';
                    break;

                case 'reject':
                case 'reupload':
                    $doc->status = DriverDocument::STATUS_REJECTED;
                    $doc->rejection_reason = $reason;
                    $doc->rejected_at = now();
                    $this->stampReview($doc, $admin);
                    $logAction = $action === 'reject' ? 'rejected' : 'reupload_requested';
                    break;

                case 'dates':
                    $logAction = 'dates_updated';
                    break;

                default: // note
                    $logAction = 'note';
            }

            $doc->save();

            $summary = $logAction === 'dates_updated' ? $this->describeDates($doc) : null;

            $this->log($doc, $admin, $logAction, $from, $doc->status, in_array($action, ['reject', 'reupload'], true) ? $reason : $summary, $note);

            return $doc;
        });
    }

    /** Move every freshly uploaded document into "under review". Returns how many. */
    public function startReview(User $driver, User $admin): int
    {
        return DB::transaction(function () use ($driver, $admin) {
            $docs = DriverDocument::where('user_id', $driver->id)
                ->where('status', DriverDocument::STATUS_UPLOADED)
                ->lockForUpdate()
                ->get();

            foreach ($docs as $doc) {
                $doc->update(['status' => DriverDocument::STATUS_UNDER_REVIEW]);
                $this->log($doc, $admin, 'started_review', DriverDocument::STATUS_UPLOADED, DriverDocument::STATUS_UNDER_REVIEW);
            }

            return $docs->count();
        });
    }

    private function guardReplace(?DriverDocument $existing, bool $confirmed): void
    {
        // An approved-but-expired document is already invalid, so replacing it needs no warning.
        if ($existing && $existing->effectiveStatus() === DriverDocument::STATUS_APPROVED && !$confirmed) {
            throw new DriverDocumentException(
                'confirm_replace',
                'This document is already approved. Replacing it will send it back for review.',
                409
            );
        }
    }

    private function stampReview(DriverDocument $doc, User $admin): void
    {
        $doc->reviewed_by = $admin->id;
        $doc->reviewed_at = now();
    }

    private function describeDates(DriverDocument $doc): string
    {
        $parts = [];
        if ($doc->issue_date) {
            $parts[] = 'Issued ' . $doc->issue_date->format('d M Y');
        }
        if ($doc->expiry_date) {
            $parts[] = 'Expires ' . $doc->expiry_date->format('d M Y');
        }

        return $parts ? implode(' · ', $parts) : 'Dates cleared';
    }

    private function clean(?string $text): ?string
    {
        $text = trim((string) $text);

        return $text === '' ? null : $text;
    }

    private function log(DriverDocument $doc, User $actor, string $action, ?string $from, ?string $to, ?string $reason = null, ?string $note = null): void
    {
        DriverDocumentReview::create([
            'driver_document_id' => $doc->id,
            'user_id'            => $doc->user_id,
            'document_type'      => $doc->type,
            'actor_id'           => $actor->id,
            'actor_role'         => self::roleOf($actor),
            'action'             => $action,
            'from_status'        => $from,
            'to_status'          => $to,
            'reason'             => $reason,
            'note'               => $note,
        ]);
    }
}
