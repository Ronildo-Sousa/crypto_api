<?php

namespace App\Http\Controllers;

use App\Actions\Currency\GetRecentPrice;
use App\DTOs\Coins\CoinPrice;
use App\Models\Coin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecentPriceController extends Controller
{
    public function __invoke(Request $request): CoinPrice|JsonResponse
    {
        $recentPrice = Coin::getPrice($request->coin, now()->subMinutes(15));

        if ($recentPrice) return $recentPrice;

        $result = GetRecentPrice::run($request->coin);

        if (!$result) {
            return response()->json(
                ['message' => 'Could not get price for this coin'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response()->json(['recent_price' => $result], Response::HTTP_OK);
    }
}
