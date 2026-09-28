@extends('layouts.auth')

@section('title', 'Personnel Login | IntRENET')

@section('content')

<div class="login-page">
    <div class="login-container">
        <div class="login-intro">
            <div class="brand">
                <div class="brand-icon">IB</div>
                <div>
                    <div class="brand-name">IntRENET</div>
                    <div class="brand-subtitle">Internet Barangay System</div>
                </div>
            </div>

```
        <div class="intro-content">
            <h1>Mabuhay!</h1>
            <p>
                A user-friendly website that allows barangay personnel
                to manage citizen concerns, process requests, and
                provide timely community services.
            </p>
        </div>
    </div>

    <div class="login-card">
        <div class="login-header">
            <h2>Personnel Login</h2>
            <p>Log in to access the personnel dashboard.</p>
        </div>

        <form method="POST" action="{{ url('/personnel/login') }}" class="login-form">
            @csrf

            @if ($errors->any())
                <div class="login-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    placeholder="Enter your personnel email"
                    autocomplete="email"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <button type="submit" class="login-button">
                Log In
            </button>

            <div class="register-section">
                <span>Are you a citizen?</span>
                <a href="{{ route('login') }}">Citizen Login</a>
            </div>
        </form>
    </div>
</div>
```

</div>
@endsection
