<?php

namespace App\Actions\Currency;

use App\Classes\CoinGecko;
use App\Contracts\CurrencyApi;
use Illuminate\Support\Collection;

class GetHistory
{
    public static function run(string $coin, string $date, CurrencyApi $currencyApi = new CoinGecko): ?Collection
    {
        return $currencyApi->getHistory($coin, $date);
    }
}
