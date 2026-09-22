<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Dedicated table for intermediate journey stops (vias).
     * Route order is: pickup -> stop(sequence 1) -> stop(2) -> ... -> dropoff
     */
    public function up(): void
    {
        if (Schema::hasTable('booking_stops')) {
            return;
        }

        Schema::create('booking_stops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->string('address');
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->unsignedInteger('sequence')->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['book_id', 'sequence']);
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_stops');
    }
};
