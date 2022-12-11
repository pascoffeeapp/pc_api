<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 
Route::fallback([Controller::class, 'notFound']);

// Api untuk init role dan permission
Route::get('init', [Controller::class, 'init']);

// Auth
Route::prefix('auth')->group(function() {

    // Api untuk register
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');

    // Api untuk login
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');

    // Api untuk memuat data yg login
    Route::get('me', [AuthController::class, 'me'])->name('auth.me')->middleware(['auth:sanctum']);

    // Api untuk logout
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

});

Route::middleware(['auth:sanctum'])->group(function() {

    // Role
    Route::prefix('role')->group(function() {
    
        // Melihat daftar role
        Route::get('/', [RoleController::class, 'index']);

        // Melihat detail role
        Route::get('/{id}', [RoleController::class, 'show']);

        // Menambahkan role
        Route::post('/', [RoleController::class, 'store']);

        // Mengedit role
        Route::post('/{id}', [RoleController::class, 'update']);

        // Menghapus role
        Route::delete('/{id}', [RoleController::class, 'destroy']);
        
    });

    Route::prefix('permission')->group(function() {
    
        // Melihat daftar izin
        Route::get('/', [PermissionController::class, 'index']);

        // Melihat detail izin
        Route::get('/{id}', [PermissionController::class, 'show']);

        // Menambahkan izin
        Route::post('/', [PermissionController::class, 'store']);

        // Mengedit izin
        Route::post('/{id}', [PermissionController::class, 'update']);

        // Menghapus izin
        Route::delete('/{id}', [PermissionController::class, 'destroy']);
        
    });

    // Outlet
    Route::prefix('outlet')->group(function() {
    
        // Melihat daftar gerai
        Route::get('/', [OutletController::class, 'index']);

        // Melihat detail gerai
        Route::get('/{id}', [OutletController::class, 'show']);

        // Menambahkan gerai
        Route::post('/', [OutletController::class, 'store']);

        // Mengedit gerai
        Route::post('/{outlet_id}', [OutletController::class, 'update'])->middleware(['outlet']);

        // Menghapus gerai
        Route::delete('/{outlet_id}', [OutletController::class, 'destroy'])->middleware(['outlet']);
        
        // Menu
        Route::prefix('/{outlet_id}/menu')->middleware(['outlet'])->group(function() {
        
            // Route::get('/', [MenuController::class, 'index']);

            // Melihat detail menu
            Route::get('/{id}', [MenuController::class, 'show']);

            // Menambah menu
            Route::post('/', [MenuController::class, 'store']);

            // Mengedit menu
            Route::post('/{id}', [MenuController::class, 'update']);

            // Menghapus menu
            Route::delete('/{id}', [MenuController::class, 'destroy']);
        });

    });
    
    // Tables
    Route::prefix('table')->group(function() {

        // Melihat daftar meja
        Route::get('/', [TableController::class, 'index']);

        // Melihat detail meja
        Route::get('/{id}', [TableController::class, 'show']);

        // Menambah meja
        Route::post('/', [TableController::class, 'store']);

        // Mengedit meja
        Route::post('/{id}', [TableController::class, 'update']);

        // Mengahpus meja
        Route::delete('/{id}', [TableController::class, 'destroy']);
    });

    // Order
    

});