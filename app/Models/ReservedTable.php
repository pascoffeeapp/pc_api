<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservedTable extends Model
{
    use HasFactory;

    public $fillable = [
        'order_id', 'table_id',
    ];

    public function getOrder() {
        return Order::find($this->order_id);
    }
}
