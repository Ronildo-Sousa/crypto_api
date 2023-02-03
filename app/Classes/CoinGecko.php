<?php

namespace App\Classes;

use App\Contracts\CurrencyApi;
use App\DTOs\Coins\CoinPrice;
use App\Models\Coin;
use App\Models\CurrencyHistory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CoinGecko implements CurrencyApi
{
    private string $baseUrl = "https://api.coingecko.com/api/v3/coins/";

    public function getRecentPrice(string $coin): ?CoinPrice
    {
        $uri = $this->baseUrl . "{$coin}/?localization=false&tickers=false&community_data=false&developer_data=false&sparkline=false";

        $response = Http::connectTimeout(0.5)->get($uri)->collect();

        return $this->handleCurrency($response, now()->subMinutes(15));
    }

    public function getHistory(string $coin, Carbon $date): ?CoinPrice
    {
        $uri = $this->baseUrl . "{$coin}/history?date={$date}&localization=false";

        $response = Http::connectTimeout(0.5)->get($uri)->collect();

        return $this->handleCurrency($response, $date);
    }

    private function handleCurrency(Collection $currencyResponse, string $date): ?CoinPrice
    {
        $coin = Coin::findByIdentifier($currencyResponse->get('id'));

         $coin->currencyHistory()
            ->create([
                'price' => $currencyResponse->get('market_data')['current_price']['usd'],
                'date' => $date
            ]);

        return Coin::GetPrice($coin->identifier, $date);
    }
}
