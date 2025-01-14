<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\ReservasiController;


use App\Http\Controllers\MenuController;


//api registco
Route::post('/register', [RegisterController::class, 'register']);

// gruping users
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']); // Ambil semua user
    // Route::post('/users', [UserController::class, 'store']); // Tambah user baru
    Route::get('/users/{id}', [UserController::class, 'show']); // Ambil user berdasarkan ID
    Route::put('/users/{id}', [UserController::class, 'update']); // Update user berdasarkan ID
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Hapus user berdasarkan ID
});

//api + data user
Route::post('/users', [UserController::class, 'create']);

// route untuk login & logout
Route::post('/login', [AuthController::class, 'login']); // Login
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']); // Logout (butuh autentikasi)
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']); // Ambil data user yang sedang login

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/meja', [MejaController::class, 'store']); // Add a table
    Route::get('/meja/{id}', [MejaController::class, 'show']); // Get table by ID
    Route::put('/meja/{id}', [MejaController::class, 'update']); // Update table
    Route::delete('/meja/{id}', [MejaController::class, 'destroy']); // Delete table




});

Route::get('/meja', [MejaController::class, 'index']); // Get all tables
Route::get('/reservasi', [ReservasiController::class, 'index']);
Route::post('/reservasi/create', [ReservasiController::class, 'create']);
Route::post('/reservasi/notification', [ReservasiController::class, 'paymentNotification']);
Route::post('/reservasi/available-tables', [ReservasiController::class, 'availableTables']);


Route::get('/menus', [MenuController::class, 'index']);
Route::get('/menus/{id}', [MenuController::class, 'show']);
Route::post('/menus', [MenuController::class, 'create']); // Menggunakan create
Route::put('/menus/{id}', [MenuController::class, 'update']);
Route::delete('/menus/{id}', [MenuController::class, 'destroy']);