<?php

namespace App\Models;

use App\DTOs\Coins\CoinPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Coin extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'name',
        'symbol',
        'homepage_url'
    ];

    public function currencyHistory(): HasMany
    {
        return $this->hasMany(CurrencyHistory::class);
    }

    public function getRecentPrice(string $coin): ?CoinPrice
    {
        $this->getPrice($coin, now());
//        $DbCoin = $this->findByIdentifier($coin);
//
//        if (!$DbCoin) return null;
//
//        $hasRecentPrice = CurrencyHistory::query()
//            ->where('coin_id', $DbCoin->id)
//            ->where('date','>=', now()->subMinutes(15))
//            ->first();
//
//        if (empty($hasRecentPrice)) return null;
//
//        return Collect([
//            "recent_price" => [
//                'name' => $DbCoin->name,
//                'symbol' => $DbCoin->symbol,
//                'date' => $hasRecentPrice->date,
//                'price' => $hasRecentPrice->price
//            ]
//        ]);
    }

    public static function GetPrice(string $coin, string $date): ?CoinPrice
    {
        $DBcoin = self::findByIdentifier($coin);

        if (!$DBcoin) return null;

        $history = CurrencyHistory::query()
            ->where('coin_id', $DBcoin->id)
            ->where('date','>=', $date)
            ->first();

        if (!$history) return null;

        return CoinPrice::from([
            'name' => $DBcoin->name,
            'symbol' => $DBcoin->symbol,
            'date' => $history->date,
            'price' => $history->price
        ]);
    }

    public static function findByIdentifier(string $coin): ?Coin
    {
        /** @var Coin $DBcoin */
        $DBcoin = Coin::query()
            ->where('identifier', $coin)
            ->first();

        return $DBcoin ?? null;
    }
}
