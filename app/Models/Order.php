<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $fillable = [
        "user_id"
    ];

    public function isDone() {
        return !is_null($this->done_at);
    }

    public function isTakeaway() {
        $tc = TakeawayCostumer::where('order_id', $this->id)->first();
        return !is_null($tc);
    }

    public function getData() {
        $ita = $this->isTakeaway();
        if ($ita) {
            $this->costumer = TakeawayCostumer::where('order_id', $this->id)->first();
        }else {
            $rt = ReservedTable::where('order_id', $this->id)->first();
            $table = Table::find($rt->table_id);
            $table->reserved_id = $rt->id;
            $this->reserved_table = $table;
        }
        $this->isTakeAway = $ita;
        $this->items = OrderItem::where('order_id', $this->id)
        ->join('menu', 'menu.id', '=', 'order_items.menu_id')
        ->select('order_items.id as item_id', 'menu.name', 'menu.image', 'menu.id', 'order_items.qty', 'menu.price', 'order_items.status')
        ->get();

        return $this;
    }
}
