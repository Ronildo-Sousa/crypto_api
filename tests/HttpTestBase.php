<?php

namespace Tests;

use Illuminate\Support\Facades\Http;

abstract class HttpTestBase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        
        Http::fake([
            "https://api.coingecko.com/api/v3/coins/*" => Http::response([
               'id' => 'bitcoin',
               'symbol' => 'btc',
               'name' => 'Bitcoin',
               'links' => ['homepage' => ["http://www.bitcoin.org"]],
               'market_data' => ['current_price' => ['usd' => 20402]],
            ])
        ]);
    }
}