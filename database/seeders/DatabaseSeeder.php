<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Coin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $coins = [
            'bitcoin',
            'dacxi',
            'ethereum',
            'cosmos',
            'terra-luna-2'
        ];

        foreach ($coins as $coin) {
            Coin::factory()->create([
                'identifier' => $coin,
                'name' => $coin,
                'symbol' => $coin,
                'homepage_url' => "https://{$coin}.com"
            ]);
        }
    }
}
