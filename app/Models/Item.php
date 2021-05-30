<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static where(string $string, mixed $id)
 */
class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $guarded = [];

    /**
     * @return HasOne
     */
    public function reservation(): HasOne
    {
        return $this->hasOne(Reservation::class);
    }

    /**
     * @return BelongsTo
     */
    public function wishlist(): BelongsTo
    {
        return $this->belongsTo(Wishlist::class, 'list_id', 'id');
    }
}
