<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    public $fillable = [
        'code',
    ];

    public function getStatus() {
        return !is_null($this->getCurrentOrder());
    }

    public function getCurrentOrder() {
        foreach (ReservedTable::where('table_id',$this->id)->get() as $order) {
            if (!$order->isDone()) {
                return $order;
            }
        }
        return null;
    }
}
