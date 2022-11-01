<?php

namespace Database\Seeders;

use App\Models\Coin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BitcoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coin::factory()->create([
            'identifier' => 'bitcoin',
            'name' => 'Bitcoin',
            'symbol' => 'BTC',
            'homepage_url' => "http://bitcoin.org"
        ]);
    }
}
