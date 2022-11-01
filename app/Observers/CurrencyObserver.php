<?php

namespace App\Observers;

use App\Models\CurrencyHistory;
use Illuminate\Support\Facades\Cache;

class CurrencyObserver
{
    public function created(CurrencyHistory $currencyHistory): void
    {
        Cache::forget('history');
        Cache::forget('current_price');
    }
}
