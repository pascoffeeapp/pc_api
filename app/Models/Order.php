<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $fillable = [
        "table_id", "user_id", "is_takeway"
    ];

    public function isDone() {
        return !is_null(Invoice::where('order_id', $this->id)->first());
    }

    public function getData() {
        $order = Order::where('id', $this->id)->first();
        $order->items = OrderItem::where('order_id', $order->id)
        ->join('menu', 'menu.id', '=', 'order_items.menu_id')
        ->select('menu.name', 'menu.image', 'menu.id', 'order_items.qty', 'menu.price', 'order_items.status')
        ->get();
        return $order;
    }
}
