
@extends('layouts.app')

@section('title', 'Track Request')

@section('page-title', 'Track Request')

@section('content')
<div class="request-page">
    <div class="request-header">
        <h1>Track Request</h1>
        <p>Check the current status of your barangay service request.</p>
    </div>

    <div class="request-search">
        <h2>Find Your Request</h2>
        <p>Enter your request reference number to check its status.</p>

        <form action="{{ url('/citizen/track-request') }}" method="POST" class="search-form">
            @csrf

            <input
                type="text"
                id="requestReference"
                name="reference_number"
                value="{{ old('reference_number') }}"
                placeholder="Enter request reference number"
                required
            >

            <button type="submit">Track Request</button>
        </form>

        @error('reference_number')
            <p class="error-message">{{ $message }}</p>
        @enderror
    </div>

    @isset($trackedRequest)
        <div class="tracking-status" id="requestStatus">
            <div class="status-header">
                <div>
                    <span class="status-label">Request Status</span>
                    <h2>Request #{{ $trackedRequest->reference_number }}</h2>
                </div>

                <span class="status-badge">
                    {{ $trackedRequest->status }}
                </span>
            </div>

            <div class="status-details">
                <div class="status-detail">
                    <span>Service</span>
                    <strong>{{ $trackedRequest->subject }}</strong>
                </div>

                <div class="status-detail">
                    <span>Date Submitted</span>
                    <strong>{{ $trackedRequest->created_at->format('F j, Y') }}</strong>
                </div>

                <div class="status-detail">
                    <span>Current Status</span>
                    <strong>{{ $trackedRequest->status }}</strong>
                </div>
            </div>

            <div class="status-message">
                @if (strtolower($trackedRequest->status) === 'resolved')
                    Your request has been resolved.
                @elseif (strtolower($trackedRequest->status) === 'pending')
                    Your request is waiting for review by barangay personnel.
                @else
                    Your request is being processed by barangay personnel.
                @endif
            </div>
        </div>
    @endisset
</div>
@endsection
