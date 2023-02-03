<?php

use App\Http\Controllers\CoinController;
use App\Http\Controllers\HistoryPriceController;
use App\Http\Controllers\RecentPriceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['validCoin'])->name('currency.')->group(function () {
    Route::get('/price/{coin?}',RecentPriceController::class)->name('price');
    Route::get('/history/{coin?}',HistoryPriceController::class)->name('history');
});

Route::apiResource('coins', CoinController::class);
