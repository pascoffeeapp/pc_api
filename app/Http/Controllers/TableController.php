<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    public function index() {
        $tables = Table::all();
        foreach ($tables as $table) {
            $table->status = $table->getStatus();
        }
        return response()->json([
            "status" => true,
            "message" => "Berhasil memuat meja",
            "body" => $tables,
        ], 200);
    }

    public function show($id) {
        $table = Table::find($id);
        if ($table) {
            return response()->json([
                "status" => true,
                "message" => "Berhasil memuat meja",
                "body" => $table,
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Meja tidak ditemukan",
            "body" => [],
        ], 404);
    }

    public function store(Request $request) {
        $val = Validator::make($request->all(), [
            "code" => 'required',
        ]);

        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 403);
        }

        $table = Table::create($request->only(['code']));
        return response()->json([
            "status" => true,
            "message" => "Berhasil mengubah menu",
            "body" => $table,
        ], 200);
    }

    public function update(Request $request, $id) {
        $val = Validator::make($request->all(), [
            "code" => 'required',
        ]);

        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 403);
        }

        $table = Table::find($id);
        if ($table) {
            $table->update($request->only(['code']));
            return response()->json([
                "status" => true,
                "message" => "Berhasil mengubah kode meja",
                "body" => $table,
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Meja tidak ditemukan",
            "body" => [],
        ], 404);
    }

    public function destroy($id) {
        $table = Table::find($id);
        if ($table) {
            $table->delete();
            return response()->json([
                "status" => true,
                "message" => "Berhasil menghapus meja",
                "body" => $table,
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Meja tidak ditemukan",
            "body" => [],
        ], 404);
    }
    
    public function showOrder($id) {
        $table = Table::find($id);
        if ($table) {
            $order = $table->getCurrentOrder();
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
        return response()->json([
            "status" => false,
            "message" => "Meja tidak ditemukan",
            "body" => [],
        ], 404);
    }
}
