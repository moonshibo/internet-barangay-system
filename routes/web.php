<?php

use App\Http\Controllers\Auth\CitizenRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [CitizenRegistrationController::class, 'create'])
    ->name('register');

Route::post('/register', [CitizenRegistrationController::class, 'store']);

Route::get('/citizen/dashboard', function () {
    return 'Citizen Dashboard';
})->middleware(['auth', 'role:citizen']);

Route::get('/personnel/dashboard', function () {
    return 'Personnel Dashboard';
})->middleware(['auth', 'role:personnel']);
