<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface CurrencyApi
{
    public function getRecentPrice(string $coin): ?Collection;
    public function getHistory(string $coin, string $date): ?Collection;
    public function finCoin(string $coin): bool;
}