<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyHistory extends Model
{
    use HasFactory;

    protected $fillable = ['price'];

    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class);
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => floor($value / 1000),
            set: fn ($value) => ($value * 1000),
        );
    }
}
