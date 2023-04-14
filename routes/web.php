<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return '<a href="/dashboard" >dashboard</a>';
});

Route::get('/dashboard', function () {
    return view('admin/index');
})->middleware('onlyAdmin');

// auth controller
Route::get('/register/', [AuthController::class, 'register_view']);
Route::post('/register/', [AuthController::class, 'register']);
Route::get('/login/', [AuthController::class, 'login_view']);
Route::post('/login/', [AuthController::class, 'login']);
Route::get('/logout/', [AuthController::class, 'logout']);
Route::get('/cek/', [AuthController::class, 'cek']);