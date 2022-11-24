<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $val = Validator::make($request->all(), [
            "username" => "required|unique:users,username",
            "password" => "required",
            "confirm_password" => "required|same:password",
        ]);

        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Invalid field",
                "body" => $val->errors(),
            ], 493);
        }

        $user = User::create([
            "username" => strtolower($request->username),
            "password" => Hash::make($request->password),
            "role_id" => $request->role_id,
        ]);

        return response()->json([
            "status" => true,
            "message" => "User successfully created",
            "body" => $user->toArray(),
        ], 200);
    }

    public function login(Request $request) {
        $val = Validator::make($request->all(), 
        [
            'username' => 'required',
            'password' => 'required'
        ]);

        if($val->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Invalid field',
                'errors' => $val->errors()
            ], 403);
        }
        if(!Auth::attempt($request->only(['username', 'password']))){
            return response()->json([
                "status" => false,
                "message" => "Username & Password does not match with our record.",
                "body" => []
            ], 401);
        }

        $user = User::where('username', $request->username)->first();
        $token = $user->createToken("API TOKEN");

        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'body' => [
                "token" => $token->plainTextToken,
            ]
        ], 200);
    }

    public function unauthorized() {
        return response()->json([
            "status" => false,
            "message" => "Unauthorized",
            "body" => [],
        ], 401);
    }

    public function me(Request $request) {
        $user = auth('sanctum')->user();
        return response()->json([
            "status" => true,
            "message" => "User has logged",
            "body" => $user,
        ], 200);
    }

    public function logout(Request $request) {
        $user = auth('sanctum')->user();
        if ($user) {
            $user->tokens()->delete();
            return response()->json([
                "status" => true,
                "message" => "User has logout",
                "body" => $user,
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "User is not logged",
            "body" => [],
        ], 401);
    }
}
