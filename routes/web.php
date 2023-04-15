<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;

Route::get('/', [FrontendController::class, 'index']);

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

// admin controller
Route::get('/profile/', [AdminController::class, 'profile'])->middleware('onlyAdmin');
Route::get('/edit_profile/', [AdminController::class, 'edit_profile'])->middleware('onlyAdmin');
Route::post('/edit_profile/', [AdminController::class, 'edit_profile_save'])->middleware('onlyAdmin');
Route::get('/change_password/', [AdminController::class, 'change_password'])->middleware('onlyAdmin');
Route::post('/change_password/', [AdminController::class, 'change_password_save'])->middleware('onlyAdmin');