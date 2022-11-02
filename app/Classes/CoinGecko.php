<?php

namespace App\Classes;

use App\Contracts\CurrencyApi;
use App\Models\Coin;
use App\Models\CurrencyHistory;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CoinGecko implements CurrencyApi
{
    private string $baseUri = "https://api.coingecko.com/api/v3/coins/";

    public function getRecentPrice(string $coin): ?Collection
    {
        $this->baseUri = $this->baseUri . "{$coin}/?localization=false&tickers=false&community_data=false&developer_data=false&sparkline=false";

        $response = Http::connectTimeout(0.5)->get($this->baseUri);

        return $this->handleCurrency($response, now());
    }

    public function getHistory(string $coin, string $date): ?Collection
    {
        $this->baseUri = $this->baseUri . "{$coin}/history?date={$date}&localization=false";

        $response = Http::connectTimeout(0.5)->get($this->baseUri);

        return $this->handleCurrency($response, $date);
    }

    public function finCoin(string $coin): bool
    {
        $this->baseUri = $this->baseUri . "{$coin}/?localization=false&tickers=false&community_data=false&developer_data=false&sparkline=false";

        $response = Http::connectTimeout(0.5)->get($this->baseUri);

        if (!$response->successful()) return false;
        $response = $response->collect();
        
        Coin::query()->create([
            'identifier' => $response->get('id'),
            'name' => $response->get('name'),
            'symbol' => $response->get('symbol'),
            'homepage_url' => $response->get('links')['homepage'][0]
        ]);

        return true;
    }

    private function handleCurrency(Response $response, string $date): ?Collection
    {
        if (!$response->successful()) {
            return null;
        }
        $response = $response->collect();

        $currentPrice = $response->get('market_data')['current_price']['usd'];

        $DbCoin = Coin::query()
            ->where('identifier', $response->get('id'))
            ->first();
        
        $history = $DbCoin->currencyHistory()->create([
            'price' => $currentPrice,
            'date' => $date
        ]);

        return Collect([
            'name' => $DbCoin->name,
            'symbol' => $DbCoin->symbol,
            'date' => $history->date,
            'price' => round($history->price, 3)
        ]);
    }
}
