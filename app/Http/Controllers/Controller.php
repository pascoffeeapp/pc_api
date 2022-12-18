<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function init() {
        Role::init();
        $role_id = Role::where('name', 'admin')->first()->id;
        User::create([
            "username" => strtolower("admin"),
            "password" => Hash::make("admin"),
            "role_id" => $role_id,
        ]);
        return response()->json([
            "status" => true,
            "message" => "Initialize success",
            "body" => [],
        ], 200);
    }

    public function notFound() {
        return response()->json([
            "status" => false,
            "message" => "Rute tidak tersedia",
            "body" => [],
        ], 404);
    }
}
