<?php

namespace App\Contracts;

use App\DTOs\Coins\CoinPrice;
use Carbon\Carbon;

interface CurrencyApi
{
    public function getRecentPrice(string $coin): ?CoinPrice;
    public function getHistory(string $coin, Carbon $date): ?CoinPrice;
}
