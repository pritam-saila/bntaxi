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
            if (!Schema::hasColumn('books', 'flight_number')) {
                $table->string('flight_number')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('books', 'airline')) {
                $table->string('airline')->nullable()->after('flight_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'flight_number')) {
                $table->dropColumn('flight_number');
            }
            if (Schema::hasColumn('books', 'airline')) {
                $table->dropColumn('airline');
            }
        });
    }
};
