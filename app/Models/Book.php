<?php

namespace App\Models;

use App\Models\Cars;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    /**
     * Give every new booking an unguessable public token, used to build the
     * confirmation / receipt / cancel links we email to the customer.
     */
    protected static function booted(): void
    {
        static::creating(function (self $booking) {
            if (empty($booking->access_token)) {
                $booking->access_token = Str::random(48);
            }
        });
    }

    /**
     * Payment methods: how the customer intends to pay.
     * key => human label
     */
    public const PAYMENT_METHODS = [
        'pay_in_car_cash' => 'Pay in Car – Cash',
        'pay_in_car_card' => 'Pay in Car – Card',
        'stripe'          => 'Stripe – Online Payment',
        'bank_transfer'   => 'Bank Transfer',
        'other'           => 'Other',
    ];

    /**
     * Payment statuses: whether payment has actually been received.
     * key => human label
     */
    public const PAYMENT_STATUSES = [
        'unpaid'          => 'Unpaid',
        'pending_payment' => 'Pending Payment',
        'partially_paid'  => 'Partially Paid',
        'paid'            => 'Paid',
        'refunded'        => 'Refunded',
        'payment_failed'  => 'Payment Failed',
    ];

    /**
     * Booking workflow statuses.
     */
    public const BOOKING_STATUSES = [
        'NEW',
        'PENDING APPROVAL',
        'CONFIRMED',
        'DRIVER ASSIGNED',
        'IN PROGRESS',
        'COMPLETED',
        'REJECTED',
        'CANCELLED',
        'REFUND PROCESSING',
        'REFUNDED',
    ];

    /**
     * How the booking reached the system.
     */
    public const SOURCES = [
        'web'   => 'Online Booking',
        'admin' => 'Created by Admin',
        'phone' => 'Phone Booking',
    ];

    protected $fillable = [
        'user_id',
        'booking_id',
        'access_token',
        'source',
        'name',
        'email',
        'phone',
        'car_id',
        'price',
        'distance',
        'duration_minutes',
        'flight_number',
        'airline',
        'from',
        'to',
        'pickup',
        'dropoff',
        'distancearr',
        'from_lat',
        'from_lng',
        'to_lat',
        'to_lng',
        'collectdate',
        'collectby',
        'collecttime',
        'deliverydate',
        'deliveryby',
        'deliverytime',
        'pickup_date',
        'pickup_time',
        'return_date',
        'return_time',
        'is_return',
        'driver_id',
        'driver_status',
        'payment_method',
        'payment_status',
        'amount_paid',
        'outstanding_amount',
        'payment_actual_method',
        'payment_date',
        'payment_confirmed_by',
        'payment_notes',
        'min_distance_override',
        'min_distance_override_reason',
        'min_distance_override_by',
        'min_distance_override_at',
        'status',
        'created_at',
        'passengers',
        'bags',
        'vias',
        'flight_origin_destination',
        'flight_arrival_time',
        'flight_airport',
        'flight_direction',
        'flight_scheduled_time',
        'special_instructions',
        'internal_notes',
        'driver_notes',
        'confirmed_at',
        'confirmed_by',
        'rejection_reason',
        'cancelled_at',
        'cancelled_by',
        'cancellation_reason',
        'refund_amount',
        'refund_status',
        'refund_transaction_reference',
        'cash_received',
        'cash_received_recorded_at',
        'timeline'
    ];

    protected $casts = [
        'distancearr' => 'array',
        'vias' => 'array',
        'timeline' => 'array',
        'min_distance_override' => 'boolean',
        'min_distance_override_at' => 'datetime',
        'payment_date' => 'datetime',
        'amount_paid' => 'decimal:2',
        'outstanding_amount' => 'decimal:2',
    ];

    public function logTimeline($event, $details = '', $actor = 'System')
    {
        $currentTimeline = $this->timeline ?? [];
        $currentTimeline[] = [
            'timestamp' => now()->toDateTimeString(),
            'event' => $event,
            'details' => $details,
            'actor' => $actor
        ];
        $this->timeline = $currentTimeline;
        $this->save();
    }

    /**
     * Record a set of field-level changes to the audit timeline.
     *
     * @param array $changes  [ 'Label' => ['from' => old, 'to' => new], ... ]
     */
    public function logChanges(array $changes, $actor = 'System', $context = 'Booking updated')
    {
        $changes = array_filter($changes, function ($c) {
            return ($c['from'] ?? null) != ($c['to'] ?? null);
        });

        if (empty($changes)) {
            return;
        }

        $lines = [];
        foreach ($changes as $label => $c) {
            $from = $c['from'] === null || $c['from'] === '' ? '—' : $c['from'];
            $to = $c['to'] === null || $c['to'] === '' ? '—' : $c['to'];
            $lines[] = "{$label}: \"{$from}\" → \"{$to}\"";
        }

        $this->logTimeline($context, implode(' | ', $lines), $actor);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function carDetail()
    {
        return $this->belongsTo(Cars::class, 'car_id');
    }

    public function stops()
    {
        return $this->hasMany(BookingStop::class, 'book_id')->orderBy('sequence');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /* ---------------------------------------------------------------------
     |  Display helpers
     * ------------------------------------------------------------------- */

    public function getPaymentMethodLabelAttribute(): string
    {
        return self::PAYMENT_METHODS[$this->payment_method] ?? ($this->payment_method ?: 'Not set');
    }

    /**
     * How to describe the payment method to a reader.
     *
     * A booking flagged as "stripe" but never actually paid online (abandoned
     * checkout) is misleading — the fare will be collected in the car — so it
     * is shown as "Pay in Car" until money genuinely moves through Stripe.
     */
    public function getPaymentMethodDisplayAttribute(): string
    {
        if ($this->payment_method === 'stripe'
            && !in_array($this->payment_status, ['paid', 'partially_paid', 'refunded'], true)) {
            return 'Pay in Car';
        }

        return $this->payment_method_label;
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return self::PAYMENT_STATUSES[$this->payment_status] ?? ($this->payment_status ?: 'Unpaid');
    }

    public function getPaymentActualMethodLabelAttribute(): string
    {
        return self::PAYMENT_METHODS[$this->payment_actual_method] ?? ($this->payment_actual_method ?: '');
    }

    public function getSourceLabelAttribute(): string
    {
        return self::SOURCES[$this->source] ?? ($this->source ? ucfirst($this->source) : 'Online Booking');
    }

    public function getSourceBadgeAttribute(): string
    {
        return [
            'web'   => 'badge-primary',
            'admin' => 'badge-dark',
            'phone' => 'badge-success',
        ][$this->source] ?? 'badge-secondary';
    }

    public function getSourceIconAttribute(): string
    {
        return [
            'web'   => 'fa-globe',
            'admin' => 'fa-user-shield',
            'phone' => 'fa-phone',
        ][$this->source] ?? 'fa-globe';
    }

    /* ---------------------------------------------------------------------
     |  Public links (emailed to the customer)
     * ------------------------------------------------------------------- */

    public function confirmationUrl(): string
    {
        return route('booking.confirmation', $this->access_token);
    }

    public function cancelUrl(): string
    {
        return route('booking.cancel.show', $this->access_token);
    }

    public function receiptUrl(): string
    {
        return route('booking.receipt', $this->access_token);
    }

    /**
     * Addresses that receive booking notifications for staff. Configured via
     * MAIL_ADMIN_RECIPIENTS (comma separated); falls back to the first admin
     * user's address if none is set.
     */
    public static function adminNotificationRecipients(): array
    {
        $recipients = (array) config('mail.admin_recipients', []);

        if (empty($recipients)) {
            $adminEmail = User::where('type', 1)->value('email');
            $recipients = $adminEmail ? [$adminEmail] : [];
        }

        return $recipients;
    }

    /**
     * Statuses from which a customer can no longer cancel.
     */
    public function isCancellable(): bool
    {
        return !in_array($this->status, ['CANCELLED', 'REJECTED', 'COMPLETED'], true);
    }

    /**
     * Full ordered address list for the journey: pickup -> stops -> dropoff.
     */
    public function routeAddresses(): array
    {
        $addresses = [];
        if ($this->pickup) {
            $addresses[] = $this->pickup;
        }
        foreach ($this->stops as $stop) {
            if ($stop->address) {
                $addresses[] = $stop->address;
            }
        }
        if ($this->dropoff) {
            $addresses[] = $this->dropoff;
        }
        return $addresses;
    }

    public function outstandingBalance(): float
    {
        if ($this->outstanding_amount !== null) {
            return (float) $this->outstanding_amount;
        }
        return max((float) $this->price - (float) $this->amount_paid, 0);
    }

    public function isStripePaid(): bool
    {
        return $this->payment_method === 'stripe'
            && $this->payment_status === 'paid'
            && !empty($this->refund_transaction_reference);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isOnlinePayment(): bool
    {
        return $this->payment_method === 'stripe';
    }

    public function isPayInCar(): bool
    {
        return in_array($this->payment_method, ['pay_in_car_cash', 'pay_in_car_card'], true);
    }

    /**
     * Only a genuine Stripe payment with a stored payment-intent reference
     * can be auto-refunded through the Stripe API.
     */
    public function canAutoRefund(): bool
    {
        return $this->payment_method === 'stripe'
            && $this->payment_status === 'paid'
            && !empty($this->refund_transaction_reference)
            && \Illuminate\Support\Str::startsWith($this->refund_transaction_reference, ['pi_', 'ch_']);
    }

    /**
     * Bootstrap badge class for the current payment status.
     */
    public function getPaymentStatusBadgeAttribute(): string
    {
        return [
            'paid'            => 'badge-success',
            'partially_paid'  => 'badge-info',
            'pending_payment' => 'badge-warning',
            'unpaid'          => 'badge-secondary',
            'refunded'        => 'badge-dark',
            'payment_failed'  => 'badge-danger',
        ][$this->payment_status] ?? 'badge-secondary';
    }
}
