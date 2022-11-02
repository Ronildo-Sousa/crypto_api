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

        $response = $this->get(route('currency.price'));

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

        $dacxiResponse = $this->get(route('currency.price', ['coin' => 'dacxi']));
        $ethResponse = $this->get(route('currency.price', ['coin' => 'ethereum']));

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

    /** @test */
    public function should_not_be_able_to_use_an_invalid_coin()
    {
        $response = $this->get(route('currency.price', ['coin' => 'some-coin']));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
