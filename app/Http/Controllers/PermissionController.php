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
        $val = Validator::make($request->all(), [
            "key" => "required",
            "description" => "required",
        ]);

        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 403);
        }

        $permission = Permission::create($request->only('key', 'description'));

        return response()->json([
            "status" => true,
            "message" => "Izin berhasil di tambahkan",
            "body" => $permission,
        ], 200);

    }

    public function update(Request $request, $id) {
        $val = Validator::make($request->all(), [
            "key" => "required",
            "description" => "required",
        ]);

        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 403);
        }

        $permission = Permission::find($id);

        if ($permission) {

            $permission->update($request->only('key', 'description'));
            
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
                "body" => $permission->toArray(),
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Izin tidak ditemukan",
            "body" => [],
        ], 404);
    }

}
