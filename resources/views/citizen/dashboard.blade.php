@extends('layouts.app')

@section('title', 'Citizen Dashboard')

@section('page-title', 'Citizen Home Dashboard')

@section('content')

<div class="dashboard">

    <!-- WELCOME SECTION -->

    <div class="welcome-section">

        <h1>Welcome, Citizen!</h1>

        <p>
            Submit, track, and manage your barangay service requests.
        </p>

    </div>


    <!-- DASHBOARD ACTIONS -->

    <div class="dashboard-actions">

        <!-- SUBMIT CONCERN -->

        <a href="{{ url('/citizen/submit-request') }}" class="action-card">

            <div class="action-icon">
                +
            </div>

            <div class="action-content">

                <h2>Submit Concern</h2>

                <p>
                    Submit a new barangay service request.
                </p>

            </div>

        </a>


        <!-- TRACK REQUEST -->

        <a href="{{ url('/citizen/track-request') }}" class="action-card">

            <div class="action-icon">
                ☷
            </div>

            <div class="action-content">

                <h2>Track Request</h2>

                <p>
                    Check the current status of your request.
                </p>

            </div>

        </a>


        <!-- HISTORY -->

        <a href="{{ url('/citizen/history') }}" class="action-card">

            <div class="action-icon">
                ◷
            </div>

            <div class="action-content">

                <h2>History</h2>

                <p>
                    View your previous barangay requests.
                </p>

            </div>

        </a>

    </div>


    <!-- REQUEST STATUS OVERVIEW -->

    <div class="request-overview">

        <div class="section-header">

            <div>
                <h2>Request Overview</h2>

                <p>
                    View the current status of your barangay requests.
                </p>
            </div>

        </div>


        <div class="status-summary">

            <!-- PENDING -->

            <div class="status-card">

                <div class="status-card-icon pending-icon">
                    ⏳
                </div>

                <div class="status-card-content">

                    <span class="status-label">
                        Pending
                    </span>

                    <strong class="status-count">
                        2
                    </strong>

                    <p>
                        Requests waiting for review
                    </p>

                </div>

            </div>


            <!-- UNDER REVIEW -->

            <div class="status-card">

                <div class="status-card-icon review-icon">
                    ◔
                </div>

                <div class="status-card-content">

                    <span class="status-label">
                        Under Review
                    </span>

                    <strong class="status-count">
                        1
                    </strong>

                    <p>
                        Requests being processed
                    </p>

                </div>

            </div>


            <!-- RESOLVED -->

            <div class="status-card">

                <div class="status-card-icon resolved-icon">
                    ✓
                </div>

                <div class="status-card-content">

                    <span class="status-label">
                        Resolved
                    </span>

                    <strong class="status-count">
                        3
                    </strong>

                    <p>
                        Completed requests
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- RECENT REQUESTS -->

    <div class="recent-requests">

        <div class="section-header">

            <div>

                <h2>Recent Requests</h2>

                <p>
                    Your latest barangay service requests.
                </p>

            </div>

            <a href="{{ url('/citizen/history') }}" class="view-all-link">
                View All
            </a>

        </div>


        <div class="request-table-wrapper">

            <table class="request-table">

                <thead>

                    <tr>

                        <th>Request ID</th>

                        <th>Concern</th>

                        <th>Status</th>

                        <th>Date Submitted</th>

                    </tr>

                </thead>

                <tbody>

                    <!-- REQUEST 1 -->

                    <tr>

                        <td>
                            <strong>REQ-001</strong>
                        </td>

                        <td>
                            Street Light
                        </td>

                        <td>

                            <span class="request-status status-pending">
                                Pending
                            </span>

                        </td>

                        <td>
                            September 28, 2026
                        </td>

                    </tr>


                    <!-- REQUEST 2 -->

                    <tr>

                        <td>
                            <strong>REQ-002</strong>
                        </td>

                        <td>
                            Garbage Collection
                        </td>

                        <td>

                            <span class="request-status status-review">
                                Under Review
                            </span>

                        </td>

                        <td>
                            September 27, 2026
                        </td>

                    </tr>


                    <!-- REQUEST 3 -->

                    <tr>

                        <td>
                            <strong>REQ-003</strong>
                        </td>

                        <td>
                            Barangay Clearance
                        </td>

                        <td>

                            <span class="request-status status-resolved">
                                Resolved
                            </span>

                        </td>

                        <td>
                            September 25, 2026
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection