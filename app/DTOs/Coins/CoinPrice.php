<?php

namespace App\DTOs\Coins;

use Spatie\LaravelData\Data;

class CoinPrice extends Data
{
    public string $name;
    public string $symbol;
    public string $date;
    public string $price;
}
