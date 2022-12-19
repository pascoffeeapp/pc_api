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

    public function isFree() {
        return !is_null($this->getCurrentOrder());
    }

    public function getCurrentOrder() {
        foreach (ReservedTable::where('table_id',$this->id)->get() as $rt) {
            if (!$rt->getOrder()->isDone()) {
                return $rt->getOrder();
            }
        }
        return null;
    }
}
