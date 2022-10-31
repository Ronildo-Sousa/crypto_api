<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecentPriceResource;
use App\Models\Coin;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function recentPrice(string $coin = 'bitcoin')
    {
        if (!$this->isValidCoin($coin)) {
            return response()->json(['message' => 'This currency is not in our database']);
        }
       return RecentPriceResource::make(Coin::first());
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
