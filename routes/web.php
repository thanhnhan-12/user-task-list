<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

// Register
Route::get('/register', [AuthController::class, 'indexRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.post')->middleware('guest');

// Login
Route::get('/login', [AuthController::class, 'indexLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');

Route::group(["middleware" => ['auth:sanctum']], function () {
    // Home
    Route::get('/', [TaskController::class, 'index'])->name('home');
    // Tasks
    Route::get('/task/create', [TaskController::class, 'create'])->name('task.new');
    // Create Task
    Route::post('/task/create', [TaskController::class, 'store'])->name('task.create');
    // Complete Task
    Route::patch('/task/{id}', [TaskController::class, 'complete'])->name('task.complete');
    // Edit Task
    Route::get('/task/{id}/edit', [TaskController::class, 'edit'])->name('task.edit');
    // Update Task
    Route::patch('/task/{id}', [TaskController::class, 'update'])->name('task.update');
    // Delete Task
    Route::delete('/task/{id}', [TaskController::class, 'delete'])->name('task.delete');
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
