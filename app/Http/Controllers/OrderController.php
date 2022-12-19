<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ReservedTable;
use App\Models\Table;
use App\Models\TakeawayCostumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index() {
        $orders = [];
        foreach (Order::all() as $order) {
            $orders[] = $order->getData();
        }
        return response()->json([
            "status" => true,
            "message" => "Berhasil memuat pesanan",
            "body" => $orders,
        ], 200);
    }

    public function store() {
        $order = Order::create([
            "user_id" => Auth::user()->id,
        ]);
        return $order;
    }

    public function createDineInOrder(Request $request) {
        $val = Validator::make($request->all(), [
            "table_id" => "required|exists:tables,id",
        ]);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 400);
        }
        $table = Table::find($request->table_id);
        if ($table) {
            if (!$table->isFree()) {
                $order = $this->store();
                ReservedTable::create([
                    "order_id" => $order->id,
                    "table_id" => $table->id,
                ]);
                return response()->json([
                    "status" => true,
                    "message" => "Berhasil membuat pesanan",
                    "body" => $order->getData(),
                ], 200);
            }
            return response()->json([
                "status" => false,
                "message" => "Meja sedang dilayani",
                "body" => [],
            ], 404);
        }
        return response()->json([
            "status" => false,
            "message" => "Meja tidak ditemukan",
            "body" => [],
        ], 404);
    }

    public function createTakeAwayOrder(Request $request) {
        $val = Validator::make($request->all(), [
            "name" => "required",
        ]);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 400);
        }
        $order = $this->store();
        TakeawayCostumer::create([
            "order_id" => $order->id,
            "name" => $request->name,
        ]);
        return response()->json([
            "status" => true,
            "message" => "Berhasil membuat pesanan",
            "body" => $order->getData(),
        ], 200);
    }

    public function updateTakeAwayOrder(Request $request, $id) {
        $val = Validator::make($request->all(), [
            "name" => "required",
        ]);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 400);
        }
        $order = Order::find($id);
        if ($order) {
            $data = $order->getData();
            $tc = TakeawayCostumer::find($data->costumer->id);
            if ($tc) {
                $tc->update([
                    "name" => $request->name,
                ]);
                return response()->json([
                    "status" => true,
                    "message" => "Berhasil mengubah pesanan",
                    "body" => $order->getData(),
                ], 200);
            }
            return response()->json([
                "status" => false,
                "message" => "Pelanggan tidak ditemukan",
                "body" => [],
            ], 404);
        }
        return response()->json([
            "status" => false,
            "message" => "Pesanan tidak ditemukan",
            "body" => [],
        ], 404);
    }

    public function destroy($id) {
        $order = Order::find($id);
        if ($order) {
            $data = $order->getData();
            if ($order->isTakeaway()) {
                $tc = TakeawayCostumer::find($data->costumer->id);
                if ($tc) {
                    $tc->delete();
                    $order->delete();
                    return response()->json([
                        "status" => true,
                        "message" => "Berhasil menghapus pesanan",
                        "body" => [],
                    ], 200);
                }
            }else {
                $rt = ReservedTable::find($order->reserved_table->reserved_id);
                if ($rt) {
                    $rt->delete();
                    $order->delete();
                    return response()->json([
                        "status" => true,
                        "message" => "Berhasil menghapus pesanan",
                        "body" => [],
                    ], 200);
                }
            }
        }
        return response()->json([
            "status" => false,
            "message" => "Pesanan tidak ditemukan",
            "body" => [],
        ], 404);
    }

    public function addItem(Request $request, $id) {
        $val = Validator::make($request->all(), [
            "menu_id" => "required",
            "qty" => "required|numeric|min_digits:1",
        ]);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 400);
        }
        $order = Order::find($id);
        if ($order) {
            $menu = Menu::find($request->menu_id);
            if ($menu) {
                $oi = OrderItem::create([
                    "menu_id" => $menu->id,
                    "qty" => $request->qty,
                    "order_id" => $order->id,
                    "status" => 0,
                ]);
                return response()->json([
                    "status" => true,
                    "message" => "Berhasil menambahkan item",
                    "body" => $oi,
                ], 200);
            }
            return response()->json([
                "status" => false,
                "message" => "Menu tidak ditemukan",
                "body" => [],
            ], 404);
        }
        return response()->json([
            "status" => false,
            "message" => "Pesanan tidak ditemukan",
            "body" => [],
        ], 404);
    }


    // Edit Status dan Quantity jangan bersamaan
    // Ubah Status Code 403 menjadi 400
    public function updateItem(Request $request, $id, $item_id) {
        $val = Validator::make($request->all(), [
            "status" => "required",
            "qty" => "required|numeric|min_digits:1",
        ]);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 400);
        }
        $order = Order::find($id);
        if ($order) {
            $oi = OrderItem::find($item_id);
            if ($oi) {
                if ($request->qty == 0) {
                    $oi->delete();
                    return response()->json([
                        "status" => true,
                        "message" => "Berhasil menghapus item",
                        "body" => [],
                    ], 200);
                }else {
                    $oi->update([
                        "qty" => $request->qty,
                        "status" => $request->status,
                    ]);
                    return response()->json([
                        "status" => true,
                        "message" => "Berhasil mengubah item",
                        "body" => $oi,
                    ], 200);
                }
            }
            return response()->json([
                "status" => false,
                "message" => "Item tidak ditemukan",
                "body" => [],
            ], 404);
        }
        return response()->json([
            "status" => false,
            "message" => "Pesanan tidak ditemukan",
            "body" => [],
        ], 404);
    }

    public function removeItem($id, $item_id) {
        $order = Order::find($id);
        if ($order) {
            $oi = OrderItem::find($item_id);
            if ($oi) {
                $oi->delete();
                return response()->json([
                    "status" => true,
                    "message" => "Berhasil menghapus item",
                    "body" => [],
                ], 200);
            }
            return response()->json([
                "status" => false,
                "message" => "Item tidak ditemukan",
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
