<?php

use Illuminate\Support\Facades\Route;

Route::get('/citizen/dashboard', function () {
    return 'Citizen Dashboard';
})->middleware(['auth', 'role:citizen']);

Route::get('/personnel/dashboard', function () {
    return 'Personnel Dashboard';
})->middleware(['auth', 'role:personnel']);