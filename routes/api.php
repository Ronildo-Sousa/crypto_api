<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\HistoryPriceController;
use App\Http\Controllers\RecentPriceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('currency.')->group(function(){
    Route::get('/price/{coin?}', RecentPriceController::class)->name('price');
    Route::get('/history/{coin?}', HistoryPriceController::class)->name('history');
});
