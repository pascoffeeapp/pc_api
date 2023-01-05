<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ReservedTable;
use App\Models\Table;
use App\Models\TakeawayCostumer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request) {
        $orders = [];
        foreach (Order::all() as $order) {
            $order = $order->getData();
            if ($request->get('type') != 'all') {
                if ($order->isDone()) {
                    continue;
                }
            }else if ($request->get('type') != 'done') {
                if (!$order->isDone()) {
                    continue;
                }
            }
            if ($request->get('by') == 'costumer') {
                if ($order->isTakeaway()) {
                    $orders[] = $order;
                }
            }else if ($request->get('by') == 'table'){
                if (!$order->isTakeaway()) {
                    $orders[] = $order;
                }
            }else {
                $orders[] = $order;
            }
        }
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
            "message" => "Pesanan tidak ditemukan",
            "body" => [],
        ], 404);
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
            "qty" => "required|numeric|min:1",
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
            if (!$order->isDone()) {
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
                "message" => "Pesanan sudah tidak berlaku",
                "body" => [],
            ], 419);
        }
        return response()->json([
            "status" => false,
            "message" => "Pesanan tidak ditemukan",
            "body" => [],
        ], 404);
    }

    // Edit Status dan Quantity jangan bersamaan
    public function updateQtyItem(Request $request, $id, $item_id) {
        $val = Validator::make($request->all(), [
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
            if (!$order->isDone()) {
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
                "message" => "Pesanan sudah tidak berlaku",
                "body" => [],
            ], 419);
        }
        return response()->json([
            "status" => false,
            "message" => "Pesanan tidak ditemukan",
            "body" => [],
        ], 404);
    }

    // Edit Status dan Quantity jangan bersamaan
    public function updateStatusItem(Request $request, $id, $item_id) {
        $val = Validator::make($request->all(), [
            "status" => "required",
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
            if (!$order->isDone()) {
                $oi = OrderItem::find($item_id);
                if ($oi) {
                    $oi->update([
                        "status" => $request->status,
                    ]);
                    return response()->json([
                        "status" => true,
                        "message" => "Berhasil mengubah item",
                        "body" => $oi,
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
                "message" => "Pesanan sudah tidak berlaku",
                "body" => [],
            ], 419);
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
            if (!$order->isDone()) {
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
                "message" => "Pesanan sudah tidak berlaku",
                "body" => [],
            ], 419);
        }
        return response()->json([
            "status" => false,
            "message" => "Pesanan tidak ditemukan",
            "body" => [],
        ], 404);
    }

    public function checkout($id) {
        $order = Order::find($id);

        if ($order) {
            if (is_null($order->done_at)) {

                $order = $order->getData();
                $items = OrderItem::where('order_id', $order->id)
                ->join('menu', 'menu.id', '=', 'order_items.menu_id')
                ->selectRaw('menu.name, menu.price, order_items.qty as quantity')
                ->get();
                $total = 0;
                foreach ($items as $item) {
                    $item->total = (int) $item->price * (int) $item->quantity;
                    $total += $item->total;
                }
                
                $data = [
                    "items" => $items,
                    "total" => $total,
                    "waiter" => $order->user->username,
                ];
                if ($order->isTakeAway()) {
                    $data['costumer'] = $order->costumer->name;
                } else {
                    $data['table'] = $order->reserved_table->code;
                }
                $order = Order::find($order->id);
                $order->done_at = date('d M Y H:i:s');
                $order->data = $data;
                $order->save();
                return response()->json([
                    "status" => true,
                    "message" => "Berhasil di simpan",
                    "body" => $order->getData(),
                ], 200);
            }

            return response()->json([
                "status" => false,
                "message" => "Pesanan sudah tidak berlaku",
                "body" => [],
            ], 403);
        }

        return response()->json([
            "status" => false,
            "message" => "Pesanan tidak ditemukan",
            "body" => [],
        ], 404);
    }
}
