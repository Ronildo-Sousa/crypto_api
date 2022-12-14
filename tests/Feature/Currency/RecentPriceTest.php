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
        $this->artisan('db:seed');

        $response = $this->getJson(route('currency.price', ['coin' => 'bitcoin']));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            "recent_price" => [
                'name',
                'symbol',
                'date',
                'price'
            ]
        ]);
    }

    /** @test */
    public function it_should_be_able_to_get_recent_coin_price_for_more_than_one_coin()
    {
        $this->artisan('db:seed');

        $dacxiResponse = $this->getJson(route('currency.price', ['coin' => 'dacxi']));
        $ethResponse = $this->getJson(route('currency.price', ['coin' => 'ethereum']));

        $dacxiResponse->assertStatus(Response::HTTP_OK);
        $dacxiResponse->assertJsonStructure([
            "recent_price" => [
                'name',
                'symbol',
                'date',
                'price'
            ]
        ]);

        $ethResponse->assertStatus(Response::HTTP_OK);
        $ethResponse->assertJsonStructure([
            "recent_price" => [
                'name',
                'symbol',
                'date',
                'price'
            ]
        ]);
    }
}
