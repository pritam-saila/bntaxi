<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('settings')->updateOrInsert(
            ['key' => 'local_operating_areas'],
            ['value' => json_encode(['brighton', 'hove']), 'created_at' => now(), 'updated_at' => now()]
        );
        DB::table('settings')->updateOrInsert(
            ['key' => 'prepayment_required_destinations'],
            ['value' => json_encode(['gatwick', 'heathrow', 'luton', 'stansted', 'city airport', 'london city', 'st pancras', 'st. pancras', 'pancras']), 'created_at' => now(), 'updated_at' => now()]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('key', ['local_operating_areas', 'prepayment_required_destinations'])->delete();
    }
};
