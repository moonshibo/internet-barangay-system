<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonnelLoginController extends Controller
{
    public function create()
    {
        return view('auth.personnel-login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'role' => 'personnel',
        ])) {
            $request->session()->regenerate();

            return redirect('/personnel/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided personnel credentials are incorrect.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/personnel/login');
    }
}