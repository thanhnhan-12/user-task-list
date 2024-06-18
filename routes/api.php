<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//Register
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
// Login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::group(["middleware" => ['auth:sanctum']], function () {
    // Profile
    Route::get('/', [TaskController::class, 'index']);
    // Logout
    Route::get('/logout', [AuthController::class, 'logout']);
});
