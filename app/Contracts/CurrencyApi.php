<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface CurrencyApi
{
    public function getRecentPrice(string $coin): Collection;
}