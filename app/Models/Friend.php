<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @method static where(string $string, mixed $id)
 */
class Friend extends Pivot
{
    use HasFactory;

    protected $table = 'friends';

    protected $guarded = [];
}
