<?php

use App\Http\Controllers\Auth\PersonnelLoginController;
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

Route::get('/personnel/login', [PersonnelLoginController::class, 'create'])
    ->name('personnel.login');

Route::post('/personnel/login', [PersonnelLoginController::class, 'store']);

Route::post('/personnel/logout', [PersonnelLoginController::class, 'destroy'])
    ->name('personnel.logout');

Route::get('/citizen/dashboard', function () {
    return view('citizen-dashboard');
})->middleware(['auth', 'role:citizen']);

Route::get('/personnel/dashboard', function () {
    return 'Personnel Dashboard';
})->middleware(['auth', 'role:personnel']);
