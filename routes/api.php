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

Route::fallback([Controller::class, 'notFound']);


Route::get('init', [Controller::class, 'init']);

Route::prefix('auth')->group(function() {

    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('unauthorized', [AuthController::class, 'unauthorized'])->name('auth.unauthorized');
    Route::get('me', [AuthController::class, 'me'])->name('auth.me')->middleware(['auth:sanctum']);
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

});

Route::middleware(['auth:sanctum'])->group(function() {

    Route::prefix('role')->group(function() {
    
        Route::get('/', [RoleController::class, 'index']);
        Route::get('/{id}', [RoleController::class, 'show']);
        Route::post('/', [RoleController::class, 'store']);
        Route::put('/{id}', [RoleController::class, 'update']);
        Route::delete('/{id}', [RoleController::class, 'destroy']);
        
    });

    Route::prefix('permission')->group(function() {
    
        Route::get('/', [PermissionController::class, 'index']);
        Route::get('/{id}', [PermissionController::class, 'show']);
        Route::post('/', [PermissionController::class, 'store']);
        Route::put('/{id}', [PermissionController::class, 'update']);
        Route::delete('/{id}', [PermissionController::class, 'destroy']);
        
    });

    // Outlet
    Route::prefix('outlet')->group(function() {
    
        Route::get('/', [OutletController::class, 'index']);
        Route::get('/{id}', [OutletController::class, 'show']);
        Route::post('/', [OutletController::class, 'store']);
        Route::put('/{id}', [OutletController::class, 'update'])->middleware(['outlet']);
        Route::delete('/{id}', [OutletController::class, 'destroy'])->middleware(['outlet']);
        
        // Menu
        Route::prefix('/{outlet_id}/menu')->middleware(['outlet'])->group(function() {
        
            // Route::get('/', [MenuController::class, 'index']);
            Route::get('/{id}', [MenuController::class, 'show']);
            Route::post('/', [MenuController::class, 'store']);
            Route::put('/{id}', [MenuController::class, 'update']);
            Route::delete('/{id}', [MenuController::class, 'destroy']);
        });

    });
    
    // Tables
    Route::prefix('table')->group(function() {

        Route::get('/', [TableController::class, 'index']);
        Route::get('/{id}', [TableController::class, 'show']);
        Route::post('/', [TableController::class, 'store']);
        Route::put('/{id}', [TableController::class, 'update']);
        Route::delete('/{id}', [TableController::class, 'destroy']);
    });

});