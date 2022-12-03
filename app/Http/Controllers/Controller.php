<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function init() {
        Role::init();
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
