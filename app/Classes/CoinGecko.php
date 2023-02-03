<?php

namespace App\Classes;

use App\Contracts\CurrencyApi;
use App\DTOs\Coins\CoinPrice;
use App\Models\Coin;
use App\Models\CurrencyHistory;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CoinGecko implements CurrencyApi
{
    private string $baseUrl = "https://api.coingecko.com/api/v3/coins/";

    public function getRecentPrice(string $coin): ?CoinPrice
    {
        $uri = $this->baseUrl . "{$coin}/?localization=false&tickers=false&community_data=false&developer_data=false&sparkline=false";

        $response = Http::connectTimeout(0.5)->get($uri)->collect();

        return $this->handleCurrency($response, now());
    }

    public function getHistory(string $coin, Carbon $date): ?CoinPrice
    {
        $uri = $this->baseUrl . "{$coin}/history?date={$date}&localization=false";

        $response = Http::connectTimeout(0.5)->get($uri)->collect();

        return $this->handleCurrency($response, $date);
    }

    public function findCoin(string $coin): bool
    {
        $uri = $this->baseUrl . "{$coin}/?localization=false&tickers=false&community_data=false&developer_data=false&sparkline=false";

        $response = Http::connectTimeout(0.5)->get($uri);

        if ($response->status() != 200) return false;

        $response = $response->collect();
        Coin::query()->create([
            'identifier' => $response->get('id'),
            'name' => $response->get('name'),
            'symbol' => $response->get('symbol'),
            'homepage_url' => $response->get('links')['homepage'][0]
        ]);

        return true;
    }

    private function handleCurrency(Collection $currencyResponse, string $date): ?CoinPrice
    {
        $currentPrice = $currencyResponse->get('market_data')['current_price']['usd'];

        $coin = Coin::query()
            ->where('identifier', $currencyResponse->get('id'))
            ->first();

        $history = $coin->currencyHistory()
            ->create([
                'price' => $currentPrice,
                'date' => $date
            ]);

        return CoinPrice::from([
            'name' => $coin->name,
            'symbol' => $coin->symbol,
            'date' => $history->date,
            'price' => $history->price
        ]);
    }
}
