<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Driver-specific details that don't belong on `users`.
 *
 * The four bank_* columns are encrypted at rest (the "encrypted" cast) and are
 * $hidden so a stray toArray()/toJson() can never leak them. Views must only
 * ever use the masked*() helpers - the full account number and sort code are
 * never rendered.
 */
class DriverProfile extends Model
{
    public const APPLICATION_PENDING  = 'pending';
    public const APPLICATION_APPROVED = 'approved';
    public const APPLICATION_DECLINED = 'declined';

    protected $fillable = [
        'user_id',
        'emergency_contact_name',
        'emergency_contact_phone',
        'vehicle_year',
        'application_status',
        'application_decided_at',
        'application_decided_by',
        'bank_account_holder',
        'bank_account_number',
        'bank_sort_code',
        'bank_name',
    ];

    protected $hidden = [
        'bank_account_holder',
        'bank_account_number',
        'bank_sort_code',
        'bank_name',
    ];

    protected $casts = [
        'vehicle_year'           => 'integer',
        'application_decided_at' => 'datetime',
        'bank_account_holder' => 'encrypted',
        'bank_account_number' => 'encrypted',
        'bank_sort_code'      => 'encrypted',
        'bank_name'           => 'encrypted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hasBankDetails(): bool
    {
        return filled($this->bank_account_holder)
            && filled($this->bank_account_number)
            && filled($this->bank_sort_code)
            && filled($this->bank_name);
    }

    /** "•••• 1234" - the only form of the account number the UI ever shows. */
    public function maskedAccountNumber(): ?string
    {
        $number = preg_replace('/\D+/', '', (string) $this->bank_account_number);

        return $number === '' ? null : '•••• ' . substr($number, -4);
    }

    /** "••-••-56" */
    public function maskedSortCode(): ?string
    {
        $code = preg_replace('/\D+/', '', (string) $this->bank_sort_code);

        return $code === '' ? null : '••-••-' . substr($code, -2);
    }

    /**
     * Does the bank account holder name match the driver's own name?
     * Order and middle names are ignored ("Sam J Smith" matches "Smith Sam").
     * Returns null when either name is missing (nothing to compare).
     */
    public function holderMatches(?string $driverName): ?bool
    {
        $holder = $this->nameTokens($this->bank_account_holder);
        $driver = $this->nameTokens($driverName);

        if (!$holder || !$driver) {
            return null;
        }

        return !array_diff($holder, $driver) || !array_diff($driver, $holder);
    }

    /** @return string[] */
    private function nameTokens(?string $name): array
    {
        $name = mb_strtolower((string) $name);
        $name = preg_replace('/\b(mr|mrs|ms|miss|dr)\b\.?/u', ' ', $name);
        $name = preg_replace('/[^\p{L}\s]+/u', ' ', $name);

        return array_values(array_filter(preg_split('/\s+/', trim($name))));
    }
}
