<?php

namespace App\Actions\Currency;

use App\Classes\CoinGecko;
use App\Contracts\CurrencyApi;
use App\DTOs\Coins\CoinPrice;
use Illuminate\Support\Collection;

class GetRecentPrice
{
    public static function run(string $coin, CurrencyApi $currencyApi = new CoinGecko): ?CoinPrice
    {
        return $currencyApi->getRecentPrice($coin);
    }
}
