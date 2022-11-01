<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Coin;
use App\Models\CurrencyHistory;
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
        $this->call(
            [
                BitcoinSeeder::class,
                AtomSeeder::class,
                DacxiSeeder::class,
                EthSeeder::class,
                LunaSeeder::class
            ]
        );
    }
}
