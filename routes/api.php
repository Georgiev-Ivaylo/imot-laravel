<?php

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

Route::apiResource('/buyers', BuyerController::class);
Route::apiResource('/estates', EstateController::class);
