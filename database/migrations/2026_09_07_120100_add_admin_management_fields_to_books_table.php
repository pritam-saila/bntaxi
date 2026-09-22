<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adds fields required for full admin booking management:
     *  - separated payment method / status / manual payment tracking
     *  - journey duration + notes split (customer vs internal vs driver)
     *  - 8-mile minimum distance override tracking
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // --- Route / journey ---
            if (!Schema::hasColumn('books', 'duration_minutes')) {
                $table->integer('duration_minutes')->nullable()->after('distance');
            }

            // --- Notes split ---
            if (!Schema::hasColumn('books', 'internal_notes')) {
                $table->text('internal_notes')->nullable()->after('special_instructions');
            }
            if (!Schema::hasColumn('books', 'driver_notes')) {
                $table->text('driver_notes')->nullable()->after('internal_notes');
            }

            // --- Payment: manual management ---
            if (!Schema::hasColumn('books', 'amount_paid')) {
                $table->decimal('amount_paid', 10, 2)->default(0)->after('payment_status');
            }
            if (!Schema::hasColumn('books', 'outstanding_amount')) {
                $table->decimal('outstanding_amount', 10, 2)->nullable()->after('amount_paid');
            }
            if (!Schema::hasColumn('books', 'payment_actual_method')) {
                $table->string('payment_actual_method')->nullable()->after('outstanding_amount');
            }
            if (!Schema::hasColumn('books', 'payment_date')) {
                $table->timestamp('payment_date')->nullable()->after('payment_actual_method');
            }
            if (!Schema::hasColumn('books', 'payment_confirmed_by')) {
                $table->string('payment_confirmed_by')->nullable()->after('payment_date');
            }
            if (!Schema::hasColumn('books', 'payment_notes')) {
                $table->text('payment_notes')->nullable()->after('payment_confirmed_by');
            }

            // --- 8-mile minimum distance override ---
            if (!Schema::hasColumn('books', 'min_distance_override')) {
                $table->boolean('min_distance_override')->default(false)->after('payment_notes');
            }
            if (!Schema::hasColumn('books', 'min_distance_override_reason')) {
                $table->text('min_distance_override_reason')->nullable()->after('min_distance_override');
            }
            if (!Schema::hasColumn('books', 'min_distance_override_by')) {
                $table->string('min_distance_override_by')->nullable()->after('min_distance_override_reason');
            }
            if (!Schema::hasColumn('books', 'min_distance_override_at')) {
                $table->timestamp('min_distance_override_at')->nullable()->after('min_distance_override_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            foreach ([
                'duration_minutes',
                'internal_notes',
                'driver_notes',
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
            ] as $col) {
                if (Schema::hasColumn('books', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
