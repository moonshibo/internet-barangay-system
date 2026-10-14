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

        <form
            class="search-form"
            method="GET"
            action="{{ url('/citizen/track-request') }}"
        >
            <input
                type="text"
                id="requestReference"
                name="reference_number"
                value="{{ old('reference_number', $referenceNumber ?? '') }}"
                placeholder="Enter request reference number"
                aria-label="Request reference number"
                aria-describedby="trackingMessage"
                autocomplete="off"
                maxlength="255"
                required
            >

            <button type="submit" id="trackRequestButton">
                Track Request
            </button>
        </form>

        <div
            id="trackingMessage"
            role="status"
            aria-live="polite"
            @if (empty($trackingMessage) && !$errors->has('reference_number')) hidden @endif
        >
            @if (!empty($trackingMessage))
                {{ $trackingMessage }}
            @endif

            @error('reference_number')
                {{ $message }}
            @enderror
        </div>
    </div>

    @if (isset($trackedRequest) && $trackedRequest)
        @php
            $status = strtolower(trim($trackedRequest->status ?? 'pending'));

            $statusLabel = match ($status) {
                'pending' => 'Pending',
                'under review', 'under_review', 'in progress', 'in_progress' => 'Under Review',
                'resolved', 'completed' => 'Resolved',
                'rejected' => 'Rejected',
                default => ucwords(str_replace(['_', '-'], ' ', $status)),
            };

            $isResolved = in_array($status, ['resolved', 'completed'], true);
            $isRejected = $status === 'rejected';
            $isUnderReview = in_array(
                $status,
                ['under review', 'under_review', 'in progress', 'in_progress'],
                true
            );

            $reference = $trackedRequest->reference_number
                ?: 'REQ-' . $trackedRequest->id;
        @endphp

        <div class="tracking-status" id="requestStatus">

            <div class="status-header">
                <div>
                    <span class="status-label">Request Status</span>
                    <h2>Request #{{ $reference }}</h2>
                </div>

                <span class="status-badge
                    {{ $isResolved ? 'status-resolved-badge' : ($isUnderReview ? 'status-review-badge' : '') }}">
                    {{ $statusLabel }}
                </span>
            </div>

            <div class="status-details">
                <div class="status-detail">
                    <span>Service</span>
                    <strong>{{ $trackedRequest->subject }}</strong>
                </div>

                <div class="status-detail">
                    <span>Category</span>
                    <strong>
                        {{ ucwords(str_replace('-', ' ', $trackedRequest->category ?? 'General')) }}
                    </strong>
                </div>

                <div class="status-detail">
                    <span>Date Submitted</span>
                    <strong>
                        {{ $trackedRequest->created_at
                            ? $trackedRequest->created_at->format('F d, Y')
                            : 'Not available' }}
                    </strong>
                </div>

                <div class="status-detail">
                    <span>Current Status</span>
                    <strong>{{ $statusLabel }}</strong>
                </div>
            </div>

            <div class="status-message">
                @if ($isResolved)
                    Your request has been marked as resolved.
                @elseif ($isRejected)
                    Your request has been marked as rejected. Please contact the barangay office if you need clarification.
                @elseif ($isUnderReview)
                    Your request is currently being reviewed by barangay personnel.
                @else
                    Your request has been submitted and is awaiting further action.
                @endif
            </div>

            <div class="request-progress">
                <h3>Request Progress</h3>

                <div class="progress-timeline">

                    <div class="progress-item completed">
                        <div class="progress-marker">✓</div>
                        <div class="progress-content">
                            <strong>Request Submitted</strong>
                            <p>Your request was successfully submitted.</p>
                            <span>
                                {{ $trackedRequest->created_at
                                    ? $trackedRequest->created_at->format('F d, Y')
                                    : 'Date not available' }}
                            </span>
                        </div>
                    </div>

                    <div class="progress-item {{ $isUnderReview ? 'active' : ($isResolved ? 'completed' : '') }}">
                        <div class="progress-marker">
                            {{ $isUnderReview || $isResolved ? '✓' : '2' }}
                        </div>
                        <div class="progress-content">
                            <strong>Under Review</strong>
                            <p>Barangay personnel review submitted requests.</p>
                            @if ($isUnderReview)
                                <span>Current Status</span>
                            @elseif ($isResolved)
                                <span>Stage completed; exact review date is not recorded.</span>
                            @endif
                        </div>
                    </div>

                    <div class="progress-item {{ $isResolved ? 'completed active' : ($isRejected ? 'active' : '') }}">
                        <div class="progress-marker">
                            {{ $isResolved ? '✓' : '3' }}
                        </div>
                        <div class="progress-content">
                            <strong>{{ $isRejected ? 'Rejected' : 'Resolved' }}</strong>
                            <p>
                                @if ($isResolved)
                                    Your request has been marked as resolved.
                                @elseif ($isRejected)
                                    Your request was rejected.
                                @else
                                    This stage will update when the request status changes.
                                @endif
                            </p>
                            @if ($isResolved || $isRejected)
                                <span>Current Status</span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    @endif

</div>
@endsection