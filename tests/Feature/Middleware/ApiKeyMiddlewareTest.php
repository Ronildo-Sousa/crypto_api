<?php

namespace Tests\Feature\Middleware;

use App\Models\CurrencyHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ApiKeyMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function users_must_have_an_api_key_to_get_the_recent_price()
    {
        $this->artisan('db:seed');

        $response = $this->getJson(route('currency.price', ['coin' => 'bitcoin']));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);


        CurrencyHistory::factory()->create(['coin_id' => 1, 'date' => now()]);
        $response = $this->getJson(route('currency.price', [
            'coin' => 'bitcoin',
            'api_key' => $this->user->api_key
        ]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "recent_price" => [
                    'name',
                    'symbol',
                    'date',
                    'price'
                ]
            ]);
    }

    /** @test */
    public function users_must_have_an_api_key_to_get_the_history_price()
    {
//        $this->withoutExceptionHandling();
        $this->artisan('db:seed');

        $response = $this->getJson(route('currency.history', [
            'coin' => 'bitcoin',
            'date' => Carbon::parse(now()->toDateTimeString())->format('d-m-Y H:i:s')
        ]));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $another = $this->getJson(route('currency.history', [
            'coin' => 'bitcoin',
            'date' => Carbon::parse(now()->toDateTimeString())->format('d-m-Y H:i:s'),
            'api_key' => 'invalid-api-key'
        ]));
        $another->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
