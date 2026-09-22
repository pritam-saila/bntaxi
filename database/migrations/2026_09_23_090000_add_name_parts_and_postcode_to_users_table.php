<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Driver registration now collects a first/last name and a post code
     * instead of one free-text "name". `name` (the combined "First Last")
     * stays on the model and keeps working everywhere else - bookings, admin
     * lists, emails - so nothing else needs to change.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name')->nullable()->after('first_name');
            }
            if (!Schema::hasColumn('users', 'postcode')) {
                $table->string('postcode', 12)->nullable()->after('address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(array_filter(['first_name', 'last_name', 'postcode'], fn ($c) => Schema::hasColumn('users', $c)));
        });
    }
};
