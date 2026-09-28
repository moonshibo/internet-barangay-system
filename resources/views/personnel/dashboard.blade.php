@extends('layouts.app')

@section('title', 'Personnel Dashboard')

@section('page-title', 'Personnel Dashboard')

@section('content')

<div class="personnel-dashboard">

    <!-- WELCOME -->

    <div class="personnel-welcome">
        <h1>Welcome, Personnel!</h1>

        <p>
            Manage, review, and process citizen service requests.
        </p>
    </div>


    <!-- REQUEST SUMMARY -->

    <div class="personnel-summary">

        <!-- TOTAL REQUESTS -->

        <div class="personnel-card">
            <div class="personnel-card-icon">
                ▤
            </div>

            <div class="personnel-card-content">
                <span>Total Requests</span>
                <strong>48</strong>
            </div>
        </div>


        <!-- PENDING -->

        <div class="personnel-card">
            <div class="personnel-card-icon">
                ◷
            </div>

            <div class="personnel-card-content">
                <span>Pending</span>
                <strong>12</strong>
            </div>
        </div>


        <!-- UNDER REVIEW -->

        <div class="personnel-card">
            <div class="personnel-card-icon">
                ↻
            </div>

            <div class="personnel-card-content">
                <span>Under Review</span>
                <strong>8</strong>
            </div>
        </div>


        <!-- RESOLVED -->

        <div class="personnel-card">
            <div class="personnel-card-icon">
                ✓
            </div>

            <div class="personnel-card-content">
                <span>Resolved</span>
                <strong>28</strong>
            </div>
        </div>

    </div>


    <!-- REQUEST MANAGEMENT -->

    <div class="personnel-section">

        <div class="personnel-section-header">

            <div>
                <h2>Request Management</h2>

                <p>
                    Review and process recently submitted citizen requests.
                </p>
            </div>

            <a
                href="{{ url('/personnel/requests') }}"
                class="view-all-button"
            >
                View All Requests
            </a>

        </div>


        <!-- REQUEST TABLE -->

        <div class="personnel-request-table">

            <div class="request-table-header">
                <span>Request ID</span>
                <span>Concern</span>
                <span>Date</span>
                <span>Status</span>
            </div>


            <!-- REQUEST 1 -->

            <a
                href="{{ route('personnel.request-details', ['id' => 'REQ-001']) }}"
                class="request-table-row"
            >
                <span>
                    <strong>REQ-001</strong>
                </span>

                <span>
                    Barangay Certificate
                </span>

                <span>
                    Sept. 27, 2026
                </span>

                <span class="request-status pending">
                    Pending
                </span>
            </a>


            <!-- REQUEST 2 -->

            <a
                href="{{ route('personnel.request-details', ['id' => 'REQ-002']) }}"
                class="request-table-row"
            >
                <span>
                    <strong>REQ-002</strong>
                </span>

                <span>
                    Community Complaint
                </span>

                <span>
                    Sept. 27, 2026
                </span>

                <span class="request-status processing">
                    Under Review
                </span>
            </a>


            <!-- REQUEST 3 -->

            <a
                href="{{ route('personnel.request-details', ['id' => 'REQ-003']) }}"
                class="request-table-row"
            >
                <span>
                    <strong>REQ-003</strong>
                </span>

                <span>
                    Barangay Clearance
                </span>

                <span>
                    Sept. 26, 2026
                </span>

                <span class="request-status resolved">
                    Resolved
                </span>
            </a>

        </div>

    </div>


    <!-- QUICK ACTIONS -->

    <div class="personnel-quick-actions">

        <!-- MANAGE REQUESTS -->

        <a
            href="{{ url('/personnel/requests') }}"
            class="personnel-action"
        >

            <div class="personnel-action-icon">
                ▤
            </div>

            <div>
                <h3>Manage Requests</h3>

                <p>
                    Review and update citizen requests.
                </p>
            </div>

        </a>


        <!-- REPORTS -->

        <a
            href="{{ url('/personnel/reports') }}"
            class="personnel-action"
        >

            <div class="personnel-action-icon">
                ▥
            </div>

            <div>
                <h3>View Reports</h3>

                <p>
                    View request activity and reports.
                </p>
            </div>

        </a>

    </div>

</div>

@endsection