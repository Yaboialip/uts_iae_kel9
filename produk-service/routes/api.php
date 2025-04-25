<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\MenuController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/menus/{id}', function ($id) {
    $menu = Menu::find($id);

    if (!$menu) {
        return response()->json([
            'success' => false,
            'message' => 'Menu tidak ditemukan',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $menu
    ]);
});


Route::get('/menus', [MenuController::class, 'index']);
Route::get('/menus/{id}', [MenuController::class, 'show']);
Route::post('/menus', [MenuController::class, 'store']);
Route::put('/menus/{id}', [MenuController::class, 'update']);
Route::delete('/menus/{id}', [MenuController::class, 'destroy']);
