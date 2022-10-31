<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
