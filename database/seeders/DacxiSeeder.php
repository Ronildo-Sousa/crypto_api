<?php

namespace Database\Seeders;

use App\Models\Coin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DacxiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coin::query()->create([
            'identifier' => 'dacxi',
            'name' => 'Dacxi',
            'symbol' => 'DACXI',
            'homepage_url' => "http://dacxicoin.io/"
        ]);
    }
}
