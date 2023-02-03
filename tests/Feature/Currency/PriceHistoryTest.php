<?php

namespace Tests\Feature\Currency;

use App\Models\Coin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\HttpTestBase;

class PriceHistoryTest extends HttpTestBase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_should_be_able_to_get_the_coin_price_based_in_a_date()
    {
        $this->artisan('db:seed');

        $response = $this->getJson(route('currency.history', [
            'date' => '01-11-2022 23:36:09',
            'coin' => 'bitcoin',
            'api_key' => $this->user->api_key
        ]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            "history_price" => [
                'name',
                'symbol',
                'date',
                'price'
            ]
        ]);
    }

    /** @test */
    public function it_should_be_able_to_get_history_coin_price_for_more_than_one_coin()
    {
        $this->artisan('db:seed');

        $Dacxiresponse = $this->getJson(route('currency.history', [
            'date' => '01-11-2022 23:36:09',
            'coin' => 'dacxi',
            'api_key' => $this->user->api_key
        ]));
        $EthResponse = $this->getJson(route('currency.history', [
            'date' => '01-11-2022 23:36:09',
            'coin' => 'ethereum',
            'api_key' => $this->user->api_key
        ]));

        $Dacxiresponse->assertStatus(Response::HTTP_OK);
        $Dacxiresponse->assertJsonStructure([
            "history_price" => [
                'name',
                'symbol',
                'date',
                'price'
            ]
        ]);

        $EthResponse->assertStatus(Response::HTTP_OK);
        $EthResponse->assertJsonStructure([
            "history_price" => [
                'name',
                'symbol',
                'date',
                'price'
            ]
        ]);
    }

    /** @test */
    public function date_should_be_required_and_valid()
    {
        $this->artisan('db:seed');

        $nullDateResponse = $this->getJson(route('currency.history', [
            'date' => null,
            'coin' => 'bitcoin',
            'api_key' => $this->user->api_key
        ]));
        $invalidDateResponse = $this->getJson(route('currency.history', [
            'date' => 'some-date',
            'coin' => 'bitcoin',
            'api_key' => $this->user->api_key
        ]));

        $nullDateResponse->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $nullDateResponse->assertJsonValidationErrorFor('date');

        $invalidDateResponse->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $invalidDateResponse->assertJsonValidationErrorFor('date');
    }
}
