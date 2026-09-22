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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            ['key' => 'auto_rejection_time_hours', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'urgent_notification_time_hours', 'value' => '2', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'cancellation_refund_rules', 'value' => json_encode([
                ['hours' => 24, 'refund_percent' => 100],
                ['hours' => 12, 'refund_percent' => 50],
                ['hours' => 0, 'refund_percent' => 0]
            ]), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
