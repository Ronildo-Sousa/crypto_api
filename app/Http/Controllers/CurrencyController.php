<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecentPriceResource;
use App\Models\Coin;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function recentPrice(string $coin = 'bitcoin')
    {
       return RecentPriceResource::make(Coin::first());
    }
}
