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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('booking_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('car_id')->nullable();
            $table->string('price')->nullable();

            $table->string('distance')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('pickup')->nullable();
            $table->string('dropoff')->nullable();
            $table->text('distancearr')->nullable();
            
            $table->decimal('from_lat', 10, 8)->nullable();
            $table->decimal('from_lng', 11, 8)->nullable();
            $table->decimal('to_lat', 10, 8)->nullable();
            $table->decimal('to_lng', 11, 8)->nullable();

            $table->string('collectdate')->nullable();
            $table->string('collectby')->nullable();
            $table->string('collecttime')->nullable();

            $table->string('deliverydate')->nullable();
            $table->string('deliveryby')->nullable();
            $table->string('deliverytime')->nullable();
            
            $table->string('pickup_date')->nullable();
            $table->string('pickup_time')->nullable();
            $table->string('return_date')->nullable();
            $table->string('return_time')->nullable();
            $table->string('is_return')->default('0');
            
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->string('driver_status')->default('pending'); // e.g., pending, accepted, rejected
            
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('pending');

            $table->string('status')->default('Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
