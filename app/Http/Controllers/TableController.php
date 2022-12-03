<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    public function index() {
        $tables = Table::all();
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
        $val = Validator::make([
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
        $val = Validator::make([
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
}
