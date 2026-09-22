<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'passengers')) {
                $table->integer('passengers')->nullable();
            }
            if (!Schema::hasColumn('books', 'bags')) {
                $table->integer('bags')->nullable();
            }
            if (!Schema::hasColumn('books', 'vias')) {
                $table->text('vias')->nullable();
            }
            if (!Schema::hasColumn('books', 'flight_origin_destination')) {
                $table->string('flight_origin_destination')->nullable();
            }
            if (!Schema::hasColumn('books', 'flight_arrival_time')) {
                $table->string('flight_arrival_time')->nullable();
            }
            if (!Schema::hasColumn('books', 'flight_airport')) {
                $table->string('flight_airport')->nullable();
            }
            if (!Schema::hasColumn('books', 'flight_direction')) {
                $table->string('flight_direction')->nullable();
            }
            if (!Schema::hasColumn('books', 'flight_scheduled_time')) {
                $table->string('flight_scheduled_time')->nullable();
            }
            if (!Schema::hasColumn('books', 'special_instructions')) {
                $table->text('special_instructions')->nullable();
            }
            if (!Schema::hasColumn('books', 'confirmed_at')) {
                $table->timestamp('confirmed_at')->nullable();
            }
            if (!Schema::hasColumn('books', 'confirmed_by')) {
                $table->unsignedBigInteger('confirmed_by')->nullable();
            }
            if (!Schema::hasColumn('books', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable();
            }
            if (!Schema::hasColumn('books', 'cancelled_at')) {
                $table->timestamp('cancelled_at')->nullable();
            }
            if (!Schema::hasColumn('books', 'cancelled_by')) {
                $table->string('cancelled_by')->nullable();
            }
            if (!Schema::hasColumn('books', 'cancellation_reason')) {
                $table->text('cancellation_reason')->nullable();
            }
            if (!Schema::hasColumn('books', 'refund_amount')) {
                $table->decimal('refund_amount', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('books', 'refund_status')) {
                $table->string('refund_status')->nullable();
            }
            if (!Schema::hasColumn('books', 'refund_transaction_reference')) {
                $table->string('refund_transaction_reference')->nullable();
            }
            if (!Schema::hasColumn('books', 'cash_received')) {
                $table->boolean('cash_received')->default(false);
            }
            if (!Schema::hasColumn('books', 'cash_received_recorded_at')) {
                $table->timestamp('cash_received_recorded_at')->nullable();
            }
            if (!Schema::hasColumn('books', 'timeline')) {
                $table->longText('timeline')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn([
                'passengers',
                'bags',
                'vias',
                'flight_origin_destination',
                'flight_arrival_time',
                'flight_airport',
                'flight_direction',
                'flight_scheduled_time',
                'special_instructions',
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
            ]);
        });
    }
};
