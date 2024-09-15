<?php

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('/login', AuthController::class . '@login');
Route::post('/register', AuthController::class . '@register');

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
