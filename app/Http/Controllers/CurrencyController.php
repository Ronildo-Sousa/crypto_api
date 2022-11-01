<?php

namespace App\Http\Controllers;

use App\Actions\Currency\GetRecentPrice;
use App\Http\Requests\PriceHistoryRequest;
use App\Models\Coin;
use App\Models\CurrencyHistory;
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

    public function history(PriceHistoryRequest $request, string $coin = 'bitcoin')
    {
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
        
        if (empty($DbCoin)) {
            return null;
        }

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
