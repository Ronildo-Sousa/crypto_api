<?php

namespace Database\Seeders;

use App\Models\Coin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coin::query()->create([
            'identifier' => 'terra-luna-2',
            'name' => 'Terra',
            'symbol' => 'LUNA',
            'homepage_url' => "http://www.terra.money/"
        ]);
    }
}
