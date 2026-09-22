<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Drivers who sign up through the public registration form are an
     * "application" until an administrator decides on it:
     *
     *   NULL      not an applicant (existing drivers, or added by an admin)
     *   pending   registered, waiting for documents to be verified
     *   approved  admin verified them and activated the account
     *   declined  admin declined the application
     *
     * Only "pending" applicants may log in before their account is active,
     * and then only to the documentation area.
     */
    public function up(): void
    {
        Schema::table('driver_profiles', function (Blueprint $table) {
            $table->string('application_status', 20)->nullable()->after('vehicle_year');
            $table->timestamp('application_decided_at')->nullable()->after('application_status');
            $table->foreignId('application_decided_by')->nullable()->after('application_decided_at')
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('driver_profiles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('application_decided_by');
            $table->dropColumn(['application_status', 'application_decided_at']);
        });
    }
};
