<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{

    public function index() {
        return response()->json([
            "status" => true,
            "message" => "Role successfully loaded",
            "body" => Role::all()->toArray(),
        ], 200);
    }

    public function show($id) {
        $role = Role::find($id);

        if ($role) {
            return response()->json([
                "status" => true,
                "message" => "Role successfully loaded",
                "body" => $role->toArray(),
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Role note found",
            "body" => [],
        ], 404);
    }
    
    public function store(Request $request) {
        $val = Validator::make($request->all(), [
            "name" => "required",
        ]);

        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Invalid field",
                "body" => $val->errors(),
            ], 403);
        }

        $role = Role::create([
            "name" => strtolower($request->name),
        ]);

        return response()->json([
            "status" => true,
            "message" => "Role successfully created",
            "body" => $role->toArray(),
        ], 200);
    }
    
    public function update(Request $request, $id) {
        $val = Validator::make($request->all(), [
            "name" => "required",
        ]);

        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Invalid field",
                "body" => $val->errors(),
            ], 403);
        }

        $role = Role::find($id);
        if ($role) {
            $role->update([
                "name" => strtolower($request->name),
            ]);
            return response()->json([
                "status" => true,
                "message" => "Role successfully updated",
                "body" => $role->toArray(),
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Role note found",
            "body" => [],
        ], 404);
    }
    
    public function destroy($id) {

        $role = Role::find($id);
        if ($role) {
            $role->delete();
            return response()->json([
                "status" => true,
                "message" => "Role successfully deleted",
                "body" => $role->toArray(),
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Role note found",
            "body" => [],
        ], 404);
    }

    public function updatePermission(Request $request, $id) {
        $role = Role::find($id);
        if ($role) {
            $permissions = RolePermission::where('role_id', $role->id)->get();
            foreach ($permissions as $permission) $permission->delete();
            if ($request->permissions) {
                foreach ($request->permissions as $permission_id) {
                    RolePermission::create([
                        "role_id" => $role->id,
                        "permission_id" => $permission_id,
                    ]);
                }
            }
            return response()->json([
                "status" => true,
                "message" => "Role note found",
                "body" => [],
            ], 200);
        }
    }


}
