<?php

namespace App\Http\Controllers;

use App\Actions\Currency\GetRecentPrice;
use App\Classes\CoinHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class RecentPriceController extends Controller
{
    public function __invoke(string $coin = "bitcoin"): Collection|JsonResponse
    {
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
}
