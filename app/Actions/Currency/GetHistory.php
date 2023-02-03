<?php

namespace App\Actions\Currency;

use App\Classes\CoinGecko;
use App\Contracts\CurrencyApi;
use App\DTOs\Coins\CoinPrice;
use Carbon\Carbon;

class GetHistory
{
    public static function run(string $coin, Carbon $date, CurrencyApi $currencyApi = new CoinGecko): ?CoinPrice
    {
        return $currencyApi->getHistory($coin, $date);
    }
}
