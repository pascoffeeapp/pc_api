<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeawayCostumer extends Model
{
    use HasFactory;

    public $fillable = [
        'order_id', 'name',
    ];
}
