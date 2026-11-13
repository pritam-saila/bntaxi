<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The Stripe Checkout session opened for a card booking. Kept so an
     * abandoned checkout can be verified with Stripe (and its payment page
     * closed) before the booking is cancelled for non-payment.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'stripe_session_id')) {
                $table->string('stripe_session_id')->nullable()->index()->after('payment_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'stripe_session_id')) {
                $table->dropColumn('stripe_session_id');
            }
        });
    }
};
