<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index() {
        $permissions = Permission::all();
        return response()->json([
            "status" => true,
            "message" => "berhasil memuat izin",
            "data" => $permissions,
        ], 200);
    }

    public function show($id) {
        $permission = Permission::find($id);
        
        if ($permission) {
            return response()->json([
                "status" => true,
                "message" => "berhasil memuat izin",
                "data" => $permission,
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "izin tidak ditemukan",
            "data" => [],
        ], 404);
    }

    public function store(Request $request) {
        $val = Validator::make([
            "key" => "required",
            "description" => "required",
        ]);

        $permission = Permission::create($request->only('key', 'description'));

        return response()->json([
            "status" => true,
            "message" => "Izin berhasil di tambahkan",
            "body" => $permission,
        ], 200);

    }

    public function update(Request $request, $id) {
        $val = Validator::make([
            "key" => "required",
            "description" => "required",
        ]);

        $permission = Permission::find($id);

        if ($permission) {

            $permission = Permission::update($request->only('key', 'description'));

            return response()->json([
                "status" => true,
                "message" => "Izin berhasil diperbaharui",
                "body" => $permission,
            ], 200);
        }

        return response()->json([
            "status" => true,
            "message" => "Izin tidak ditemukan",
            "body" => [],
        ], 404);

    }

    public function destroy($id) {

        $permission = Permission::find($id);

        if ($permission) {

            $permission->delete();

            return response()->json([
                "status" => true,
                "message" => "Izin berhasil di dihapus",
                "body" => [],
            ], 200);
        }
    }

}
