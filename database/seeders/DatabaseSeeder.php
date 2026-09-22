<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Content;
use Database\Seeders\CreateUsersSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        Content::create([
            'title' => 'About Us',
            'description' => 'About Us Content',
        ]);
        $this->call(CreateUsersSeeder::class);
        $this->call(PricingSeeder::class);
    }
}
