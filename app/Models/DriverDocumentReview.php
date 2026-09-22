<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One line of the append-only document audit trail.
 * `reason` is shown to the driver; `note` is internal (admins only).
 */
class DriverDocumentReview extends Model
{
    public const UPDATED_AT = null;

    public const ACTIONS = [
        'uploaded'           => 'Uploaded',
        'replaced'           => 'Replaced',
        'deleted'            => 'Deleted',
        'started_review'     => 'Review started',
        'approved'           => 'Approved',
        'rejected'           => 'Rejected',
        'reupload_requested' => 'Re-upload requested',
        'dates_updated'      => 'Dates updated',
        'note'               => 'Internal note',
    ];

    protected $fillable = [
        'driver_document_id',
        'user_id',
        'document_type',
        'actor_id',
        'actor_role',
        'action',
        'from_status',
        'to_status',
        'reason',
        'note',
    ];

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    public function actionLabel(): string
    {
        return self::ACTIONS[$this->action] ?? ucfirst(str_replace('_', ' ', $this->action));
    }
}
