<?php

use App\Http\Controllers\Auth\PersonnelLoginController;
use App\Http\Controllers\Auth\CitizenLoginController;
use App\Http\Controllers\Auth\CitizenRegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Citizen Authentication
|--------------------------------------------------------------------------
*/

Route::get('/register', [CitizenRegistrationController::class, 'create'])
    ->name('register');

Route::post('/register', [CitizenRegistrationController::class, 'store']);

Route::get('/login', [CitizenLoginController::class, 'create'])
    ->name('login');

Route::post('/login', [CitizenLoginController::class, 'store']);

Route::post('/logout', [CitizenLoginController::class, 'destroy'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Personnel Authentication
|--------------------------------------------------------------------------
*/

Route::get('/personnel/login', [PersonnelLoginController::class, 'create'])
    ->name('personnel.login');

Route::post('/personnel/login', [PersonnelLoginController::class, 'store']);

Route::post('/personnel/logout', [PersonnelLoginController::class, 'destroy'])
    ->name('personnel.logout');

/*
|--------------------------------------------------------------------------
| Protected Citizen Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/citizen/dashboard', function () {
    return view('citizen.dashboard');
})->middleware(['auth', 'role:citizen']);

/*
|--------------------------------------------------------------------------
| Protected Personnel Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/personnel/dashboard', function () {
    return view('personnel.dashboard');
})->middleware(['auth', 'role:personnel']);

/*
|--------------------------------------------------------------------------
| Citizen Frontend
|--------------------------------------------------------------------------
*/

Route::view('/citizen/dashboard-preview', 'citizen.dashboard')
    ->middleware(['auth', 'role:citizen']);

Route::view('/citizen/submit-request', 'citizen.submit-request')
    ->middleware(['auth', 'role:citizen']);

Route::view('/citizen/track-request', 'citizen.track-request')
    ->middleware(['auth', 'role:citizen']);

Route::view('/citizen/history', 'citizen.history')
    ->middleware(['auth', 'role:citizen']);

/*
|--------------------------------------------------------------------------
| Personnel Frontend
|--------------------------------------------------------------------------
*/

Route::view('/personnel/dashboard-preview', 'personnel.dashboard')
    ->middleware(['auth', 'role:personnel']);

Route::view('/personnel/requests', 'personnel.requests')
    ->middleware(['auth', 'role:personnel']);

Route::get('/personnel/requests/details/{id}', function ($id) {
    return view('personnel.request-details', [
        'requestId' => $id,
    ]);
})->middleware(['auth', 'role:personnel'])
  ->name('personnel.request-details');

Route::view('/personnel/reports', 'personnel.reports')
    ->middleware(['auth', 'role:personnel']);