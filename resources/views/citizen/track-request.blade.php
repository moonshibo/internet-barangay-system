@extends('layouts.app')

@section('title', 'Track Request')

@section('page-title', 'Track Request')

@section('content')

<div class="request-page">

<div class="request-header">

    <h1>Track Request</h1>

    <p>
        Check the current status of your barangay service request.
    </p>

</div>


<div class="request-search">

    <h2>Find Your Request</h2>

    <p>
        Enter your request reference number to check its status.
    </p>

    <div class="search-form">

        <input
            type="text"
            id="requestReference"
            placeholder="Enter request reference number"
        >

        <button type="button" id="trackRequestButton">
            Track Request
        </button>

    </div>

</div>


<!-- MOCK REQUEST STATUS -->

<div class="tracking-status" id="requestStatus">

    <div class="status-header">

        <div>
            <span class="status-label">Request Status</span>
            <h2>Request #REQUEST-002</h2>
        </div>

        <span class="status-badge status-review-badge">
            Under Review
        </span>

    </div>


    <div class="status-details">

        <div class="status-detail">

            <span>Service</span>

            <strong>
                Barangay Service Request
            </strong>

        </div>


        <div class="status-detail">

            <span>Date Submitted</span>

            <strong>
                September 27, 2026
            </strong>

        </div>


        <div class="status-detail">

            <span>Current Status</span>

            <strong>
                Under Review
            </strong>

        </div>

    </div>


    <div class="status-message">

        Your request is currently being reviewed by barangay personnel.

    </div>

    <div class="request-progress">

    <h3>Request Progress</h3>

    <div class="progress-timeline">

        <div class="progress-item completed">

            <div class="progress-marker">
                ✓
            </div>

            <div class="progress-content">
                <strong>Request Submitted</strong>
                <p>
                    Your request was successfully submitted.
                </p>
                <span>September 27, 2026</span>
            </div>

        </div>


        <div class="progress-item active">

            <div class="progress-marker">
                2
            </div>

            <div class="progress-content">
                <strong>Under Review</strong>
                <p>
                    Barangay personnel are currently reviewing your request.
                </p>
                <span>Current Status</span>
            </div>

        </div>


        <div class="progress-item">

            <div class="progress-marker">
                3
            </div>

            <div class="progress-content">
                <strong>Resolved</strong>
                <p>
                    Your request will be marked resolved once the concern
                    has been completed.
                </p>
            </div>

        </div>

    </div>

</div>

</div>

</div>

@endsection
