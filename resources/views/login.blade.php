@extends('layouts.auth')

@section('title', 'Login | IntRENET')

@section('content')

<div class="login-page">

    <div class="login-container">

        {{-- LEFT SIDE --}}
        <div class="login-intro">

            <div class="brand">
                <div class="brand-icon">
                    IB
                </div>

                <div>
                    <div class="brand-name">IntRENET</div>
                    <div class="brand-subtitle">
                        Internet Barangay System
                    </div>
                </div>
            </div>

            <div class="intro-content">

                <h1>Mabuhay!</h1>

                <p>
                    A user-friendly website that allows residents to easily
                    submit their concerns, helping barangay staff direct each
                    request to the right service and let citizens conveniently
                    track the progress of their requests.
                </p>

            </div>

        </div>


        {{-- RIGHT SIDE --}}
        <div class="login-card">

            <div class="login-header">

                <h2>Welcome!</h2>

                <p>
                    Log in to continue.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('login.process') }}"
                class="login-form"
            >

                @csrf

                @if ($errors->any())
                    <div class="login-error">
                        {{ $errors->first() }}
                    </div>
                @endif


                {{-- EMAIL --}}
                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        placeholder="Enter your email address"
                        autocomplete="email"
                        value="{{ old('email') }}"
                        required
                    >

                </div>


                {{-- PASSWORD --}}
                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >

                </div>


                {{-- OPTIONS --}}
                <div class="login-options">

                    <label class="remember-me">

                        <input
                            type="checkbox"
                            name="remember"
                        >

                        <span>Remember me</span>

                    </label>


                    <a
                        href="#"
                        class="forgot-password"
                    >
                        Forgot Password?
                    </a>

                </div>


                {{-- LOGIN --}}
                <button
                    type="submit"
                    class="login-button"
                >
                    Log In
                </button>


                {{-- REGISTER --}}
                <div class="register-section">

                    <span>
                        Don't have an account?
                    </span>

                    <a href="/register">
                        Register here
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection