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
        Schema::table('cars', function (Blueprint $table) {
            if (!Schema::hasColumn('cars', 'call_for_quote')) {
                $table->boolean('call_for_quote')->default(false);
            }
            if (!Schema::hasColumn('cars', 'mileage_multiplier')) {
                $table->float('mileage_multiplier')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            if (Schema::hasColumn('cars', 'call_for_quote')) {
                $table->dropColumn('call_for_quote');
            }
            if (Schema::hasColumn('cars', 'mileage_multiplier')) {
                $table->dropColumn('mileage_multiplier');
            }
        });
    }
};
