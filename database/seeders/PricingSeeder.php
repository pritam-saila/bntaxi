<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cars;
use App\Models\FixedPrice;

class PricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Update Saloon Car (ID: 3)
        Cars::where('id', 3)->update([
            'description' => 'Max 4 passengers, 2 large suitcases, and 2 carry on.'
        ]);

        // 2. Update Multi seater / Mercedes Vito (ID: 2)
        Cars::where('id', 2)->update([
            'call_for_quote' => true,
            'description' => 'Can carry 8 passengers and up to 8 Large Bags or 5 Large Bags and 4 Cabin Bags.'
        ]);

        // Set mileage multiplier to 4.0 for all cars in the database
        Cars::query()->update([
            'mileage_multiplier' => 4.0
        ]);

        // 3. Clear existing fixed prices and populate competitive ones (10 less)
        FixedPrice::truncate();

        $fixed_prices = [
            [
                'car_id' => 3,
                'destination_name' => 'Gatwick south terminal',
                'drop_price' => 75.00,
                'pickup_price' => 85.00,
                'keywords' => 'gatwick, south'
            ],
            [
                'car_id' => 3,
                'destination_name' => 'Gatwick north terminal',
                'drop_price' => 75.00,
                'pickup_price' => 85.00,
                'keywords' => 'gatwick, north'
            ],
            [
                'car_id' => 3,
                'destination_name' => 'Heathrow Terminal 1',
                'drop_price' => 145.00,
                'pickup_price' => 155.00,
                'keywords' => 'heathrow, terminal 1, t1'
            ],
            [
                'car_id' => 3,
                'destination_name' => 'Heathrow Terminal 2',
                'drop_price' => 145.00,
                'pickup_price' => 155.00,
                'keywords' => 'heathrow, terminal 2, t2'
            ],
            [
                'car_id' => 3,
                'destination_name' => 'Heathrow Terminal 3',
                'drop_price' => 145.00,
                'pickup_price' => 155.00,
                'keywords' => 'heathrow, terminal 3, t3'
            ],
            [
                'car_id' => 3,
                'destination_name' => 'Heathrow Terminal 4',
                'drop_price' => 145.00,
                'pickup_price' => 155.00,
                'keywords' => 'heathrow, terminal 4, t4'
            ],
            [
                'car_id' => 3,
                'destination_name' => 'Heathrow Terminal 5',
                'drop_price' => 145.00,
                'pickup_price' => 155.00,
                'keywords' => 'heathrow, terminal 5, t5'
            ],
            [
                'car_id' => 3,
                'destination_name' => 'Luton Airport',
                'drop_price' => 245.00,
                'pickup_price' => 255.00,
                'keywords' => 'luton'
            ],
            [
                'car_id' => 3,
                'destination_name' => 'London Stansted Airport',
                'drop_price' => 245.00,
                'pickup_price' => 255.00,
                'keywords' => 'stansted'
            ],
            [
                'car_id' => 3,
                'destination_name' => 'London City Airport',
                'drop_price' => 200.00,
                'pickup_price' => 210.00,
                'keywords' => 'london city,city airport'
            ],
            [
                'car_id' => 3,
                'destination_name' => 'London St Pancras',
                'drop_price' => 245.00,
                'pickup_price' => 255.00,
                'keywords' => 'st pancras,st. pancras,pancras'
            ]
        ];

        foreach ($fixed_prices as $fp) {
            FixedPrice::create($fp);
        }
    }
}
