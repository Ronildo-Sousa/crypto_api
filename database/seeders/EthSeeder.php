<?php

namespace Database\Seeders;

use App\Models\Coin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coin::factory()->create([
            'identifier' => 'ethereum',
            'name' => 'Ethereum',
            'symbol' => 'ETH',
            'homepage_url' => "http://www.ethereum.org/"
        ]);
    }
}
