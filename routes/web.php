<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
| Login
|--------------------------------------------------------------------------
*/

// Show login page
Route::get('/login', function () {
    return view('login');
})->name('login');

// Process login
Route::post('/login', function () {

    $credentials = request()->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $remember = request()->boolean('remember');

    if (Auth::attempt($credentials, $remember)) {

        request()->session()->regenerate();

        $user = Auth::user();

        // Redirect according to user's role
        if ($user->role === 'citizen') {
            return redirect('/citizen/dashboard-preview');
        }

        if ($user->role === 'personnel') {
            return redirect('/personnel/dashboard-preview');
        }

        // If the account has an unknown role
        Auth::logout();

        return back()->withErrors([
            'email' => 'Your account does not have a valid role.',
        ])->onlyInput('email');
    }

    return back()->withErrors([
        'email' => 'The provided email or password is incorrect.',
    ])->onlyInput('email');

})->name('login.process');

Route::view('/register', 'register')->name('register');


/*
|--------------------------------------------------------------------------
| Testing
|--------------------------------------------------------------------------
*/

Route::view('/frontend-test', 'frontend-test');


/*
|--------------------------------------------------------------------------
| Protected Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::get('/citizen/dashboard', function () {
    return 'Citizen Dashboard';
})->middleware(['auth', 'role:citizen']);


Route::get('/personnel/dashboard', function () {
    return 'Personnel Dashboard';
})->middleware(['auth', 'role:personnel']);


/*
|--------------------------------------------------------------------------
| Citizen Frontend
|--------------------------------------------------------------------------
*/

Route::view('/citizen/dashboard-preview', 'citizen.dashboard');

Route::view('/citizen/submit-request', 'citizen.submit-request');

Route::view('/citizen/track-request', 'citizen.track-request');

Route::view('/citizen/history', 'citizen.history');


/*
|--------------------------------------------------------------------------
| Personnel Frontend
|--------------------------------------------------------------------------
*/

Route::view('/personnel/dashboard-preview', 'personnel.dashboard');

Route::view('/personnel/requests', 'personnel.requests');

Route::get('/personnel/requests/details/{id}', function ($id) {

    return view('personnel.request-details', [
        'requestId' => $id
    ]);

})->name('personnel.request-details');


Route::view('/personnel/reports', 'personnel.reports');
