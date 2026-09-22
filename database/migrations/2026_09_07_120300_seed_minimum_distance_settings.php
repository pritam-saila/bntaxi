<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('settings')->updateOrInsert(
            ['key' => 'minimum_journey_miles'],
            ['value' => '8', 'created_at' => now(), 'updated_at' => now()]
        );
        DB::table('settings')->updateOrInsert(
            ['key' => 'minimum_journey_enforced'],
            ['value' => '1', 'created_at' => now(), 'updated_at' => now()]
        );
        DB::table('settings')->updateOrInsert(
            ['key' => 'minimum_journey_message'],
            [
                'value' => 'Unfortunately, we do not accept bookings for journeys under 8 miles.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'minimum_journey_miles',
            'minimum_journey_enforced',
            'minimum_journey_message',
        ])->delete();
    }
};
