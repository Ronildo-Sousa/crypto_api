<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function recentPrice(string $coin = 'bitcoin')
    {
        dd($coin);
    }
}
