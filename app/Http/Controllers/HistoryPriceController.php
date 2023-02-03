<?php

namespace App\Http\Controllers;

use App\Actions\Currency\GetHistory;
use App\Classes\CoinHelper;
use App\DTOs\Coins\CoinPrice;
use App\Http\Requests\PriceHistoryRequest;
use App\Models\Coin;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class HistoryPriceController extends Controller
{
    public function __invoke(PriceHistoryRequest $request, string $coin): CoinPrice|JsonResponse
    {
        $history = Coin::getPrice($coin, $request->validated('date'));

        if ($history) return $history;

        $date = Carbon::parse($request->validated('date'));
        $result = GetHistory::run($coin, $date);

        if (!$result) {
            return response()->json(
                ['message' => 'Could not get price for this coin'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return response()->json(['history_price' => $result], Response::HTTP_OK);
    }
}
