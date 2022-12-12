<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::all();
        return response()->json([
            "status" => true,
            "message" => "Berhasil memuat pesanan",
            "body" => $orders,
        ], 200);
    }

    public function show($id) {
        $order = Order::find($id);
        if ($order) {
            return response()->json([
                "status" => true,
                "message" => "Berhasil memuat pesanan",
                "body" => $order->getData(),
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Berhasil memuat pesanan",
            "body" => [],
        ], 404);
    }

    public function store(Request $request) {
        $val = Validator::make($request->all(), [
            "is_takeway" => "required|boolean",
            "table_id" => "",
        ]);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 403);
        }
        $order = Order::create([
            ...$request->only(['table_id', 'is_takeway']),
            "user_id" => auth()->user()->id,
        ]);
        return response()->json([
            "status" => true,
            "message" => "Berhasil membuat pesanan",
            "body" => $order->getData(),
        ], 200);
    }

    public function update(Request $request, $id) {
        $val = Validator::make($request->all(), [
            "table_id" => "",
            "is_takeway" => "required|boolean",
        ]);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 403);
        }
        $order = Order::find($id);
        if ($order) {
            $order = Order::create($request->only(['table_id', 'is_takeway']));
            return response()->json([
                "status" => true,
                "message" => "Berhasil mengubah pesanan",
                "body" => $order->getData(),
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Berhasil memuat pesanan",
            "body" => [],
        ], 404);
    }

    public function destroy($id) {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
            return response()->json([
                "status" => true,
                "message" => "Berhasil menghapus pesanan",
                "body" => $order,
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Pesanan tidak ditemukan",
            "body" => [],
        ], 404);
    }

    public function storeItem(Request $request, $id) {
        $val = Validator::make($request->all(), [
            "menu_id" => "required",
            "qty" => "required|numeric",
        ]);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 403);
        }
        $order = Order::find($id);
        if ($order) {
            OrderItem::create([
                ...$request->only(['menu_id', 'qty']),
                "status" => 0,
                "order_id" => $id,
            ]);
            return response()->json([
                "status" => true,
                "message" => "Berhasil menambahkan item pesanan",
                "body" => $order->getData(),
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Pesanan tidak ditemukan",
            "body" => [],
        ], 404);
    }

    public function updateItem(Request $request, $id, $item_id) {
        $val = Validator::make($request->all(), [
            "qty" => "required|numeric",
            "status" => "required",
        ]);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 403);
        }
        $order = Order::find($id);
        if ($order) {
            $orderItem = OrderItem::find($item_id);
            if ($orderItem) {
                $orderItem->update($request->only(['status', 'qty']));
                return response()->json([
                    "status" => true,
                    "message" => "Berhasil menambahkan item pesanan",
                    "body" => $order->getData(),
                ], 200);
            }
            return response()->json([
                "status" => false,
                "message" => "Item pesanan tidak ditemukan",
                "body" => [],
            ], 404);
        }
        return response()->json([
            "status" => false,
            "message" => "Pesanan tidak ditemukan",
            "body" => [],
        ], 404);
    }

    public function destroyItem($id, $item_id) {
        $order = Order::find($id);
        if ($order) {
            $orderItem = OrderItem::find($item_id);
            if ($orderItem) {
                $orderItem->delete();
                return response()->json([
                    "status" => true,
                    "message" => "Berhasil menambahkan item pesanan",
                    "body" => $order->getData(),
                ], 200);
            }
            return response()->json([
                "status" => false,
                "message" => "Item pesanan tidak ditemukan",
                "body" => [],
            ], 404);
        }
        return response()->json([
            "status" => false,
            "message" => "Pesanan tidak ditemukan",
            "body" => [],
        ], 404);
    }

}
