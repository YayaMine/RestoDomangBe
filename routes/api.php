<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

Route::post('/register', [RegisterController::class, 'register']);


// gruping users
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']); // Ambil semua user
    // Route::post('/users', [UserController::class, 'store']); // Tambah user baru
    Route::get('/users/{id}', [UserController::class, 'show']); // Ambil user berdasarkan ID
    Route::put('/users/{id}', [UserController::class, 'update']); // Update user berdasarkan ID
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Hapus user berdasarkan ID
});



// route untuk login & logout
Route::post('/login', [AuthController::class, 'login']); // Login
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']); // Logout (butuh autentikasi)
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']); // Ambil data user yang sedang login



// Rute untuk meja (TableController)
Route::resource('meja', TableController::class);