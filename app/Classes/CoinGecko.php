<?php

namespace App\Classes;

use App\Contracts\CurrencyApi;
use App\Models\Coin;
use App\Models\CurrencyHistory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CoinGecko implements CurrencyApi
{
    private string $baseUri = "https://api.coingecko.com/api/v3/coins/";

    public function getRecentPrice(string $coin): Collection
    {
        $this->baseUri = $this->baseUri . "{$coin}/?localization=false&tickers=false&community_data=false&developer_data=false&sparkline=false";

        $response = Http::get($this->baseUri)->collect();

        return $this->handleCurrency($response, now());
    }

    public function getHistory(string $coin, string $date): Collection
    {
        $this->baseUri = $this->baseUri . "{$coin}/history?date={$date}&localization=false";

        $response = Http::get($this->baseUri)->collect();

        return $this->handleCurrency($response, $date);
    }

    private function handleCurrency(Collection $response, string $date): Collection
    {
        $currentPrice = $response->get('market_data')['current_price']['usd'];

        $DbCoin = Coin::query()
            ->where('identifier', $response->get('id'))
            ->first();

        $history = $DbCoin->currencyHistory()->create([
            'price' => $currentPrice,
            'date' => Carbon::parse($date)
        ]);

        return Collect([
            'name' => $DbCoin->name,
            'symbol' => $DbCoin->symbol,
            'price' => $history->price
        ]);
    }
}
