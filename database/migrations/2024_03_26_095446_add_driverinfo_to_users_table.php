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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'company_name')) {
                $table->string('company_name')->nullable();
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable();
            }
            if (!Schema::hasColumn('users', 'vatnumber')) {
                $table->string('vatnumber')->nullable();
            }
            if (!Schema::hasColumn('users', 'companyregnumber')) {
                $table->string('companyregnumber')->nullable();
            }
            if (!Schema::hasColumn('users', 'vehicleregnumber')) {
                $table->string('vehicleregnumber')->nullable();
            }
            if (!Schema::hasColumn('users', 'make')) {
                $table->string('make')->nullable();
            }
            if (!Schema::hasColumn('users', 'model')) {
                $table->string('model')->nullable();
            }
            if (!Schema::hasColumn('users', 'hireandrewardinsurance')) {
                $table->string('hireandrewardinsurance')->nullable();
            }
            if (!Schema::hasColumn('users', 'goodsintransitinsuance')) {
                $table->string('goodsintransitinsuance')->nullable();
            }
            if (!Schema::hasColumn('users', 'publicliabilityinsurance')) {
                $table->string('publicliabilityinsurance')->nullable();
            }
            if (!Schema::hasColumn('users', 'drivinginsurance')) {
                $table->string('drivinginsurance')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
