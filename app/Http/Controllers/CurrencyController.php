<?php

namespace App\Http\Controllers;

use App\Actions\Currency\GetHistory;
use App\Actions\Currency\GetRecentPrice;
use App\Http\Requests\PriceHistoryRequest;
use App\Models\Coin;
use App\Models\CurrencyHistory;
use Carbon\Carbon;
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
        if (!$this->isValidCoin($coin)) {
            return response()->json(['message' => 'This currency is not in our database'], Response::HTTP_NOT_FOUND);
        }

        $history = $this->hasHistory($coin, $request->validated('date'));

        if ($history) {
            return $history;
        }

        return GetHistory::run($coin, $request->validated('date'));
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
        $DbCoin = $this->findCoin($coin);

        if (empty($DbCoin)) {
            return null;
        }

        $hasRecentPrice = CurrencyHistory::query()
            ->where('coin_id', $DbCoin->id)
            ->where('created_at', '<', now()->addHours(2))
            ->first();

        if (empty($hasRecentPrice)) {
            return null;
        }
        return Collect([
            'name' => $DbCoin->name,
            'symbol' => $DbCoin->symbol,
            'price' => $hasRecentPrice->price
        ]);
    }

    private function hasHistory(string $coin, string $date): ?Collection
    {
        $DbCoin = $this->findCoin($coin);

        if (empty($DbCoin)) {
            return null;
        }

        $hasHistory = CurrencyHistory::query()
            ->where('coin_id', $DbCoin->id)
            ->whereDate('created_at', Carbon::parse($date))->first();

        if (empty($hasHistory)) {
            return null;
        }

        return Collect([
            'name' => $DbCoin->name,
            'symbol' => $DbCoin->symbol,
            'price' => $hasHistory->price
        ]);
    }

    private function findCoin(string $coin): ?Coin
    {
        $DbCoin = Coin::query()
            ->where('identifier', $coin)
            ->first();

        if (empty($DbCoin)) {
            return null;
        }
        return $DbCoin;
    }
}
