<?php

namespace Database\Seeders;

use App\Models\Coin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AtomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coin::query()->create([
            'identifier' => 'cosmos',
            'name' => 'Cosmos Hub',
            'symbol' => 'ATOM',
            'homepage_url' => "http://cosmos.network/"
        ]);
    }
}
