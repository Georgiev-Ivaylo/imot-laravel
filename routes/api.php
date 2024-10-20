<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\EstateController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return response()->json([
        'message' => 'Welcome to our API service',
        'data' => [],
    ]);
});

Route::post('/login/user', [AuthController::class, 'user']);
Route::apiResource('estates', EstateController::class);

Route::prefix('admin')
    ->middleware(['auth:sanctum'])
    ->as('admin.')
    ->group(
        function () {
            Route::apiResource('estates', EstateController::class);
        }
    );

// Route::group(['admin'], [
//     Route::apiResource('estates', EstateController::class),
// ])->middleware(['auth:sanctum', 'publish']);

Route::apiResource('/buyers', BuyerController::class);
