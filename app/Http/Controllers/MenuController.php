<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    // public function index($outlet_id) {
    //     if (!Outlet::find($outlet_id)) {
    //         return response()->json([
    //             "status" => false,
    //             "message" => "Gerai tidak ditemukan",
    //             "body" => [],
    //         ], 404);
    //     }
    //     $menu = Menu::all();
    //     return response()->json([
    //         "status" => true,
    //         "message" => "Berhasil memuat menu",
    //         "body" => $menu,
    //     ], 200);
    // }
    
    public function show($outlet_id, $id) {
        $menu = Menu::find($id);
        if ($menu) {
            return response()->json([
                "status" => true,
                "message" => "Berhasil memuat menu",
                "body" => $menu,
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Menu tidak ditemukan",
            "body" => [],
        ], 404);
    }

    public function store(Request $request, $outlet_id) {
        $val = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 403);
        }
        $filename = '';
        if ($file = $request->file('image')) {
            $dir = 'uploads/menu';
            $filename = time().rand(1111,9999).'.'.$file->getClientOriginalExtension();
            $file->move($dir, $filename);
        }
        $menu = Menu::create([
            "name" => $request->name,
            "image" => $filename,
            "description" => $request->description,
            "outlet_id" => $outlet_id,
            "price" => $request->price,
            "status" => 0,
        ]);
        return response()->json([
            "status" => true,
            "message" => "Berhasil menambah menu",
            "body" => $menu,
        ], 200);
    }

    public function update(Request $request, $outlet_id, $id) {
        if (!Outlet::find($outlet_id)) {
            return response()->json([
                "status" => false,
                "message" => "Gerai tidak ditemukan",
                "body" => [],
            ], 404);
        }
        $val = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'status' => 'required',
        ]);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Inputan tidak benar",
                "body" => $val->errors(),
            ], 403);
        }
        $menu = Menu::find($id);

        if ($menu) {
            $filename = $menu->image;
            if ($file = $request->file('image')) {
                $dir = 'uploads/menu';
                if (file_exists(public_path($dir.$filename))) {
                    unlink(public_path($dir.$filename));
                }
                $filename = time().rand(1111,9999).'.'.$file->getClientOriginalExtension();
                $file->move($dir, $filename);
            }
            $menu->update([
                "name" => $request->name,
                "image" => $filename,
                "description" => $request->description,
                "outlet_id" => $outlet_id,
                "price" => $request->price,
                "status" => $request->price,
            ]);
            return response()->json([
                "status" => true,
                "message" => "Berhasil mengubah menu",
                "body" => $menu,
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Menu tidak ditemukan",
            "body" => [],
        ], 404);
    }
    
    public function destroy($outlet_id, $id) {
        $menu = Menu::find($id);
        if ($menu) {
            $dir = 'uploads/menu/';
            $filename = $menu->image;
            // dd(file_exists(public_path($dir.$filename)));
            if (file_exists(public_path($dir.$filename))) {
                unlink(public_path($dir.$filename));
            }
            $menu->delete();
            return response()->json([
                "status" => true,
                "message" => "Berhasil menghapus menu",
                "body" => $menu,
            ], 200);
        }
        return response()->json([
            "status" => false,
            "message" => "Menu tidak ditemukan",
            "body" => [],
        ], 404);
    }
}
