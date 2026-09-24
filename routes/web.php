<?php

use App\Http\Controllers\Auth\CitizenLoginController;
use App\Http\Controllers\Auth\CitizenRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [CitizenRegistrationController::class, 'create'])
    ->name('register');

Route::post('/register', [CitizenRegistrationController::class, 'store']);

Route::get('/login', [CitizenLoginController::class, 'create'])
    ->name('login');

Route::post('/login', [CitizenLoginController::class, 'store']);

Route::post('/logout', [CitizenLoginController::class, 'destroy'])
    ->name('logout');

Route::get('/citizen/dashboard', function () {
    return view('citizen-dashboard');
})->middleware(['auth', 'role:citizen']);

Route::get('/personnel/dashboard', function () {
    return 'Personnel Dashboard';
})->middleware(['auth', 'role:personnel']);
