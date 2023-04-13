<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '<a href="/dashboard" >dashboard</a>';
});

Route::get('/dashboard', function () {
    return view('admin/index');
});