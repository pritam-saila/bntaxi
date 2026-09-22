<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The same email address should be usable for a customer account and a
     * driver account - they're different roles, not the same login. `email`
     * was globally unique; this replaces that with a unique (email, type)
     * pair, so one email can be a customer AND a driver, but not two of the
     * same type.
     *
     * Note: Laravel's password-reset flow (routes/auth.php via Auth::routes())
     * looks a user up by email alone, so it isn't type-aware. It's already
     * dead in this app - every login page's "Forgot Password?" link is a bare
     * `href="#"` - so this is safe today. Wiring password reset back up later
     * needs a type-aware lookup.
     */
    public function up(): void
    {
        $indexes = collect(DB::select('SHOW INDEX FROM users'))->pluck('Key_name')->unique();

        if ($indexes->contains('users_email_unique')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique('users_email_unique');
            });
        }

        if (!$indexes->contains('users_email_type_unique')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique(['email', 'type'], 'users_email_type_unique');
            });
        }
    }

    public function down(): void
    {
        $indexes = collect(DB::select('SHOW INDEX FROM users'))->pluck('Key_name')->unique();

        if ($indexes->contains('users_email_type_unique')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique('users_email_type_unique');
            });
        }

        if (!$indexes->contains('users_email_unique')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('email', 'users_email_unique');
            });
        }
    }
};
