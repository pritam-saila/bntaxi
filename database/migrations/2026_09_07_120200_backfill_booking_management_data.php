<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * One-off data migration:
     *  - map legacy payment_method / payment_status values onto the new vocabularies
     *  - initialise amount_paid / outstanding_amount from the existing price
     *  - normalise a few legacy booking status values
     *  - move intermediate vias/distancearr entries into the booking_stops table
     *
     * Safe to re-run: every step checks current state before writing.
     */
    public function up(): void
    {
        $methodMap = [
            null              => 'pay_in_car_cash',
            ''                => 'pay_in_car_cash',
            'cash'            => 'pay_in_car_cash',
            'Cash'            => 'pay_in_car_cash',
            'CASH'            => 'pay_in_car_cash',
            'stripe'          => 'stripe',
            'Stripe'          => 'stripe',
            'STRIPE'          => 'stripe',
        ];

        $statusMap = [
            null                => 'unpaid',
            ''                  => 'unpaid',
            'pending'           => 'unpaid',
            'Pending'           => 'unpaid',
            'PENDING'           => 'unpaid',
            'unpaid'            => 'unpaid',
            'paid'             => 'paid',
            'Paid'             => 'paid',
            'PAID'             => 'paid',
            'refunded'         => 'refunded',
            'Refunded'         => 'refunded',
        ];

        $legacyBookingStatusMap = [
            'Pending'  => 'PENDING APPROVAL',
            'pending'  => 'PENDING APPROVAL',
            'Inactive' => 'PENDING APPROVAL',
            'inactive' => 'PENDING APPROVAL',
            'Active'   => 'CONFIRMED',
            'active'   => 'CONFIRMED',
            'Completed'=> 'COMPLETED',
            'completed'=> 'COMPLETED',
            'Cancelled'=> 'CANCELLED',
            'cancelled'=> 'CANCELLED',
            'Rejected' => 'REJECTED',
            'rejected' => 'REJECTED',
        ];

        $books = DB::table('books')->get();

        foreach ($books as $book) {
            $update = [];

            // --- payment method ---
            $pm = $book->payment_method;
            $newMethod = $methodMap[$pm] ?? (in_array($pm, [
                'pay_in_car_cash', 'pay_in_car_card', 'stripe', 'bank_transfer', 'other',
            ], true) ? $pm : 'pay_in_car_cash');
            if ($newMethod !== $pm) {
                $update['payment_method'] = $newMethod;
            }

            // --- payment status ---
            $ps = $book->payment_status;
            $newStatus = $statusMap[$ps] ?? (in_array($ps, [
                'unpaid', 'pending_payment', 'partially_paid', 'paid', 'refunded', 'payment_failed',
            ], true) ? $ps : 'unpaid');
            if ($newStatus !== $ps) {
                $update['payment_status'] = $newStatus;
            }

            // --- amount paid / outstanding ---
            $price = (float) ($book->price ?? 0);
            if ($book->amount_paid === null || (float) $book->amount_paid == 0.0) {
                $amountPaid = $newStatus === 'paid' ? $price : 0.0;
                $update['amount_paid'] = $amountPaid;
            } else {
                $amountPaid = (float) $book->amount_paid;
            }
            if ($book->outstanding_amount === null) {
                $update['outstanding_amount'] = max($price - $amountPaid, 0);
            }

            // --- legacy booking status ---
            if (isset($legacyBookingStatusMap[$book->status])) {
                $update['status'] = $legacyBookingStatusMap[$book->status];
            }

            if (!empty($update)) {
                DB::table('books')->where('id', $book->id)->update($update);
            }

            // --- migrate vias -> booking_stops ---
            $this->migrateStops($book);
        }
    }

    private function migrateStops($book): void
    {
        if (DB::table('booking_stops')->where('book_id', $book->id)->exists()) {
            return; // already migrated
        }

        $raw = $book->vias ?: $book->distancearr;
        if (!$raw) {
            return;
        }

        $list = json_decode($raw, true);
        if (!is_array($list)) {
            $unserialized = @unserialize($raw);
            $list = is_array($unserialized) ? $unserialized : null;
        }
        if (!is_array($list) || count($list) <= 2) {
            return;
        }

        // First entry = pickup, last = dropoff; everything between is a stop.
        $intermediate = array_slice(array_values($list), 1, -1);
        $seq = 1;
        foreach ($intermediate as $address) {
            if (!is_string($address) || trim($address) === '') {
                continue;
            }
            DB::table('booking_stops')->insert([
                'book_id'    => $book->id,
                'address'    => trim($address),
                'sequence'   => $seq++,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Data migration only; booking_stops rows are removed with the table drop.
        if (Schema::hasTable('booking_stops')) {
            DB::table('booking_stops')->delete();
        }
    }
};
