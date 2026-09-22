<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Records how each booking came in: online form, entered by an admin,
     * or taken over the phone.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'source')) {
                $table->string('source', 20)->default('web')->after('booking_id');
            }
        });

        // Existing rows were all created through the online booking form.
        DB::table('books')->whereNull('source')->update(['source' => 'web']);
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'source')) {
                $table->dropColumn('source');
            }
        });
    }
};
