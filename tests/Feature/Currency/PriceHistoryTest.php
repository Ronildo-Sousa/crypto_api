<?php

namespace Tests\Feature\Currency;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\HttpTestBase;
use Tests\TestCase;

class PriceHistoryTest extends HttpTestBase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_be_able_to_get_the_coin_price_based_in_a_date()
    {
        $this->artisan('db:seed');

        $response = $this->getJson(route('currency.history', ['date' => '2022-11-01']));

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
