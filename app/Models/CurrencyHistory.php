<?php

namespace App\Models;

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
}
