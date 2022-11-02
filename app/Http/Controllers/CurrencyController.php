<?php

namespace App\Http\Controllers;

use App\Actions\Currency\GetHistory;
use App\Actions\Currency\GetRecentPrice;
use App\Classes\CoinHelper;
use App\Http\Requests\PriceHistoryRequest;
use Symfony\Component\HttpFoundation\Response;
class CurrencyController extends Controller
{
    public function recentPrice(string $coin = 'bitcoin')
    {
        if (!CoinHelper::isValidCoin($coin)) {
            return response()->json(['message' => 'This currency is not in our database'], Response::HTTP_NOT_FOUND);
        }
        
        $recentPrice = CoinHelper::hasRecentPrice($coin);

        if ($recentPrice) return $recentPrice;

        $result = GetRecentPrice::run($coin);

        if (!$result) {
            return response()->json(
                ['message' => 'Could not get price for this coin'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response()->json(['recent_price' => $result], Response::HTTP_OK);
    }

    public function history(PriceHistoryRequest $request, string $coin = 'bitcoin')
    {
        if (!CoinHelper::isValidCoin($coin)) {
            return response()->json(['message' => 'This currency is not in our database'], Response::HTTP_NOT_FOUND);
        }

        $history = CoinHelper::hasHistory($coin, $request->validated('date'));

        if ($history) return $history;
       
        $result = GetHistory::run($coin, $request->validated('date'));

        if (!$result) {
            return response()->json(
                ['message' => 'Could not get price for this coin'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response()->json(['history_price' => $result], Response::HTTP_OK);
    }
}
