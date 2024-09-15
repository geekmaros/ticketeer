<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', AuthController::class . '@login');
Route::post('/register', AuthController::class . '@register');
Route::middleware('auth:sanctum')->post('/logout', AuthController::class . '@logout');

Route::get('/tickets', function () {
    $tickets = Ticket::all();
    return response()->json([
        'message' => $tickets,
        'status' => 200,
    ], 200);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
