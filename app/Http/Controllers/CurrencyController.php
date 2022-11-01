<?php

namespace App\Http\Controllers;

use App\Actions\Currency\GetRecentPrice;
use App\Http\Resources\RecentPriceResource;
use App\Http\Resources\RecentPriceResourceCollection;
use App\Models\Coin;
use App\Models\CurrencyHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class CurrencyController extends Controller
{
    public function recentPrice(string $coin = 'bitcoin')
    {
        if (!$this->isValidCoin($coin)) {
            return response()->json(['message' => 'This currency is not in our database'], Response::HTTP_NOT_FOUND);
        }

        $recentPrice = $this->hasRecentPrice($coin);

        if ($recentPrice) {
            return $recentPrice;
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

    private function hasRecentPrice(string $coin): ?Collection
    {
        $DbCoin = Coin::query()
            ->where('identifier', $coin)
            ->first();

        $hasRecentPrice = CurrencyHistory::query()
            ->where('coin_id', $DbCoin->id)
            ->where('created_at', '<', now()->addHours(2))
            ->first();

        if (!$hasRecentPrice) {
            return null;
        }
        return Collect([
            'name' => $DbCoin->name,
            'symbol' => $DbCoin->symbol,
            'price' => $hasRecentPrice->price
        ]);
    }
}
