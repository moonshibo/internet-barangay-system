```blade
@extends('layouts.app')

@section('title', 'Submit Concern as Guest')
@section('page-title', 'Submit Concern')

@section('content')

<div class="request-page">

    <div class="request-header">
        <h2>Submit a Concern as Guest</h2>
        <p>
            You may submit a barangay concern without creating an account.
            Please provide the required information below.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="request-form-card">

        <form
            id="guestRequestForm"
            method="POST"
            action="{{ url('/submit-request') }}"
        >
            @csrf

            <div class="form-group">
                <label for="guest_name">Full Name</label>
                <input
                    type="text"
                    id="guest_name"
                    name="guest_name"
                    placeholder="Enter your full name"
                    value="{{ old('guest_name') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="guest_contact">Contact Information</label>
                <input
                    type="text"
                    id="guest_contact"
                    name="guest_contact"
                    placeholder="Enter your contact number or email"
                    value="{{ old('guest_contact') }}"
                    required
                >
                <small class="form-help">
                    This may be used by barangay personnel if follow-up is necessary.
                </small>
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input
                    type="text"
                    id="subject"
                    name="subject"
                    placeholder="Enter a short title for your concern"
                    value="{{ old('subject') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="concern_text">Description</label>
                <textarea
                    id="concern_text"
                    name="concern_text"
                    rows="6"
                    placeholder="Describe your concern in detail..."
                    required
                >{{ old('concern_text') }}</textarea>

                <small class="form-help">
                    Please provide enough information for barangay personnel to review your concern.
                </small>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input
                    type="text"
                    id="location"
                    name="location"
                    placeholder="Enter the location related to your concern"
                    value="{{ old('location') }}"
                >

                <small class="form-help">
                    Example: Purok 3, Barangay Hall area
                </small>
            </div>

            <div class="submission-info">
                <p>
                    <strong>Guest submission:</strong>
                    After submitting your concern, you will receive a unique
                    reference number. Keep this number to check your request status.
                </p>
            </div>

            <div class="form-actions">
                <a href="{{ url('/login') }}" class="button button-secondary">
                    Back to Login
                </a>

                <button
                    type="submit"
                    class="button button-primary"
                >
                    Submit Concern
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
```