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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->text('address')->nullable();
            $table->string('vatnumber')->nullable();
            $table->string('companyregnumber')->nullable();
            $table->string('vehicleregnumber')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('hireandrewardinsurance')->nullable();
            $table->string('goodsintransitinsuance')->nullable();
            $table->string('publicliabilityinsurance')->nullable();
            $table->string('drivinginsurance')->nullable();
            $table->tinyInteger('type')->default(0);
            $table->tinyInteger('status')->default(1);
            /* Users: 0=>User, 1=>Admin, 2=>Manager */
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
