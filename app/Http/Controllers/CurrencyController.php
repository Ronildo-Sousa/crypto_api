<?php

namespace App\Http\Controllers;

use App\Actions\Currency\GetRecentPrice;
use App\Http\Resources\RecentPriceResource;
use App\Http\Resources\RecentPriceResourceCollection;
use App\Models\Coin;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function recentPrice(string $coin = 'bitcoin')
    {
        if (!$this->isValidCoin($coin)) {
            return response()->json(['message' => 'This currency is not in our database']);
        }
       
        return GetRecentPrice::run($coin);
    }

    private function isValidCoin(string $coin): bool
    {
        return in_array($coin, [
            'bitcoin',
            'dacxi',
            'ethereum',
            'cosmos',
            'terra-luna-2'
        ]);
    }
}
