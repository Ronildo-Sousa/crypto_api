<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyHistory extends Model
{
    use HasFactory;

    protected $fillable = ['price', 'date'];

    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class);
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value / 1000),
            set: fn ($value) => ($value * 1000),
        );
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d-m-Y H:i:s'),
            set: fn ($value) => Carbon::parse($value)->format('Y-m-d H:i:s'),
        );
    }
}
