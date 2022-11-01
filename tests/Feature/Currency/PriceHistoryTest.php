<?php

namespace Tests\Feature\Currency;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\HttpTestBase;

class PriceHistoryTest extends HttpTestBase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_be_able_to_get_the_coin_price_based_in_a_date()
    {
        $this->artisan('db:seed');

        $response = $this->getJson(route('currency.history', ['date' => '01-11-2022']));

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

    /** @test */
    public function it_should_be_able_to_get_history_coin_price_for_more_than_one_coin()
    {
        $this->artisan('db:seed');

        $Dacxiresponse = $this->getJson(route('currency.history', [
            'date' => '01-11-2022',
            'coin' => 'dacxi'
        ]));
        $EthResponse = $this->getJson(route('currency.history', [
            'date' => '01-11-2022',
            'coin' => 'ethereum'
        ]));

        $Dacxiresponse->assertStatus(Response::HTTP_OK);
        $Dacxiresponse->assertJsonStructure([
            'name',
            'symbol',
            'price'
        ]);

        $EthResponse->assertStatus(Response::HTTP_OK);
        $EthResponse->assertJsonStructure([
            'name',
            'symbol',
            'price'
        ]);
    }

    /** @test */
    public function date_should_be_required_and_valid()
    {
        $nullDateResponse = $this->getJson(route('currency.history', ['date' => null]));
        $invalidDateResponse = $this->getJson(route('currency.history', ['date' => 'some-date']));

        $nullDateResponse->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $nullDateResponse->assertJsonValidationErrorFor('date');

        $invalidDateResponse->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $invalidDateResponse->assertJsonValidationErrorFor('date');
    }
}
