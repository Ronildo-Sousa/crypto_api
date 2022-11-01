<?php

use App\Http\Controllers\CurrencyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('currency.')->group(function(){
    Route::get('/price/{coin?}', [CurrencyController::class, 'recentPrice'])->name('price');
    Route::get('/history/{coin?}', [CurrencyController::class, 'history'])->name('history');
});
