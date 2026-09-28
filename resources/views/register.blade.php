@extends('layouts.auth')

@section('title', 'Register | IntRENET')

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
                    <div class="brand-name">
                        IntRENET
                    </div>

                    <div class="brand-subtitle">
                        Internet Barangay System
                    </div>
                </div>

            </div>


            <div class="intro-content">

                <h1>Mabuhay!</h1>

                <p>
                    Create your IntRENET account and easily submit,
                    monitor, and track your concerns through your
                    barangay's online service portal.
                </p>

            </div>

        </div>


        {{-- RIGHT SIDE --}}
        <div class="login-card register-card">

            <div class="login-header">

                <h2>Create an Account</h2>

                <p>
                    Register to get started.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('register') }}"
                class="login-form">
                @csrf
			    	
		@if ($errors->any())
    		    <div class="login-error">
        		{{ $errors->first() }}
	            </div>
		@endif

                {{-- NAME --}}
                <div class="form-group">

                    <label for="name">
                        Full Name
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        placeholder="Enter your full name"
                        autocomplete="name"
                        value="{{ old('name') }}"
                        required
                    >

                </div>


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
                        placeholder="Create a password"
                        autocomplete="new-password"
                        required
                    >

                </div>


                {{-- CONFIRM PASSWORD --}}
                <div class="form-group">

                    <label for="password_confirmation">
                        Confirm Password
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirm your password"
                        autocomplete="new-password"
                        required
                    >

                </div>


                {{-- PRIVACY CONSENT --}}
                <div class="consent-group">

                    <label class="consent-label">

                        <input
                            type="checkbox"
                            name="privacy_consent"
                            required
                        >

                        <span>
                            I agree to the
                            <a href="#" class="consent-link">
                                Privacy Notice
                            </a>
                            and consent to the collection and
                            processing of my information.
                        </span>

                    </label>

                </div>


                {{-- REGISTER --}}
                <button
                    type="submit"
                    class="login-button"
                >
                    Create Account
                </button>


                {{-- LOGIN LINK --}}
                <div class="register-section">

                    <span>
                        Already have an account?
                    </span>

                    <a href="/login">
                        Log in here
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection