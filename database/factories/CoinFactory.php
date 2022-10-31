<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coin>
 */
class CoinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $coins = [
            'bitcoin',
            'dacxi',
            'ethereum',
            'cosmos',
            'terra-luna-2'
        ];
        $random = rand(0, 4);

        return [
            'identifier' => $coins[$random],
            'name' => $coins[$random],
            'symbol' => $coins[$random],
            'homepage_url' => "https://{$coins[$random]}.com"
        ];
    }
}
