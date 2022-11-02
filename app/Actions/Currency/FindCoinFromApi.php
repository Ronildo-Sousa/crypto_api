<?php

namespace App\Actions\Currency;

use App\Classes\CoinGecko;
use App\Contracts\CurrencyApi;

class FindCoinFromApi
{
    public static function run(string $coin, CurrencyApi $currencyApi = new CoinGecko): bool
    {
        return $currencyApi->finCoin($coin);
    }
}