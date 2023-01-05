<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {
        $users = [];
        foreach (User::all() as $user) {
            $users[] = $user->getData();
        }
        return response()->json([
            "status" => true,
            "message" => "Berhasil memuat pengguna",
            "body" => $users,
        ], 200);
    }

    public function show($id) {
        $user = User::find($id);
        if ($user) {
            return response()->json([
                "status" => true,
                "message" => "Berhasil memuat pengguna",
                "body" => $user->getData(),
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Pengguna tidak ditemukan",
            "body" => [],
        ], 404);
    }

    public function store(Request $request) {
        $val = Validator::make($request->all(), [
            "username" => "required|unique:users,username",
            "password" => "required",
            "confirm_password" => "required|same:password",
            "role_id" => "required",
        ]);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => [],
            ], 400);
        }
        $user = User::create([
            "username" => strtolower($request->username),
            "password" => Hash::make($request->password),
            "role_id" => $request->role_id,
        ]);
        return response()->json([
            "status" => true,
            "message" => "Berhasil menambahkan pengguna",
            "body" => $user->getData(),
        ], 200);
    }

    public function update(Request $request, $id) {
        $v = [];
        if (strlen($request->password) > 0) {
            $v = [
                "password" => "",
                "confirm_password" => "required|same:password",
            ];
        }
        $val = Validator::make($request->all(), [
            "username" => "required",
            "role_id" => "required",
            ...$v,
        ]);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 400);
        }
        $user = User::find($id);
        if ($user) {
            $data = [
                "username" => $request->username,
                "role_id" => $request->role_id,  
            ];
            if (strlen(trim($request->password)) > 0) $data['password'] = $request->password;
            $user->update([
                "username" => strtolower($request->username),
                "password" => Hash::make($request->password),
                "role_id" => $request->role_id,
            ]);
            return response()->json([
                "status" => true,
                "message" => "Pengguna berhasil di update",
                "body" => $user->getData(),
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Pengguna tidak ditemukan",
            "body" => [],
        ], 404);
    }

    function getOutlet($id) {
        $outlet = Outlet::where('owner_id', $id)->first();
        if ($outlet) {
            return response()->json([
                "status" => true,
                "message" => "Pengguna berhasil di update",
                "body" => $outlet->getData(),
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Outlet tidak ditemukan",
            "body" => [],
        ], 404);
    }

    public function destroy($id) {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json([
                "status" => true,
                "message" => "Berhasil menghapus pengguna",
                "body" => $user,
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Pengguna tidak ditemukan",
            "body" => [],
        ], 404);
    }
}
