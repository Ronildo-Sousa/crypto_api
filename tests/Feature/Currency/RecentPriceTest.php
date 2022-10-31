<?php

namespace Tests\Feature\Currency;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\HttpTestBase;
class RecentPriceTest extends HttpTestBase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_be_able_to_get_recent_coin_price()
    {
        $response = $this->get(route('currency.price'));
      
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'name',
            'symbol',
            'price'
        ]);

        $this->assertIsString($response['name']);
        $this->assertIsString($response['symbol']);
        $this->assertIsNumeric($response['price']);
    }
}
