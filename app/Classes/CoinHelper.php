<?php

namespace App\Classes;

use App\Models\Coin;
use App\Models\CurrencyHistory;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CoinHelper
{
    public static function hasRecentPrice(string $coin): ?Collection
    {
        $DbCoin = self::findCoin($coin);

        if (empty($DbCoin)) return null;

        $hasRecentPrice = CurrencyHistory::query()
            ->where('coin_id', $DbCoin->id)
            ->whereDate('created_at', '>=', now()->subHours(2))
            ->first();

        if (empty($hasRecentPrice)) return null;

        return Collect([
            "recent_price" => [
                'name' => $DbCoin->name,
                'symbol' => $DbCoin->symbol,
                'date' => $hasRecentPrice->date,
                'price' => $hasRecentPrice->price
            ]
        ]);
    }

    public static function hasHistory(string $coin, string $date): ?Collection
    {
        $DbCoin = self::findCoin($coin);

        if (empty($DbCoin)) return null;

        $hasHistory = CurrencyHistory::query()
            ->where('coin_id', $DbCoin->id)
            ->whereDate('date', Carbon::parse($date))->first();

        if (empty($hasHistory)) return null;

        return Collect([
            "history_price" => [
                'name' => $DbCoin->name,
                'symbol' => $DbCoin->symbol,
                'date' => $hasHistory->date,
                'price' => $hasHistory->price
            ]
        ]);
    }

    public static function isValidCoin(string $coin): bool
    {
        $validCoin = Coin::query()->where('identifier', $coin)->count();
        
        return ($validCoin > 0);
    }

    private static function findCoin(string $coin): ?Coin
    {
        $DbCoin = Coin::query()
            ->where('identifier', $coin)
            ->first();

        if (empty($DbCoin)) return null;

        return $DbCoin;
    }
}