<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Unguessable per-booking token used to build the public confirmation,
     * receipt and cancellation links (the ones we email to customers who
     * booked without an account). `booking_id` is derived from time() and is
     * far too predictable to expose in a cancel link.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'access_token')) {
                $table->string('access_token', 64)->nullable()->unique()->after('booking_id');
            }
        });

        DB::table('books')->whereNull('access_token')->orderBy('id')->each(function ($row) {
            DB::table('books')->where('id', $row->id)->update(['access_token' => Str::random(48)]);
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'access_token')) {
                $table->dropColumn('access_token');
            }
        });
    }
};
