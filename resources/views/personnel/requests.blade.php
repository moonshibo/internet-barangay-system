@extends('layouts.app')

@section('title', 'Manage Requests')

@section('page-title', 'Request Management')

@section('content')

<div class="personnel-requests">

<!-- PAGE HEADER -->

<div class="personnel-requests-header">

    <div>
        <h1>Manage Requests</h1>

        <p>
            Review and manage service requests submitted by citizens.
        </p>
    </div>

</div>


<!-- SUMMARY -->

<div class="request-summary">

    <div class="request-summary-card">

        <div class="request-summary-icon">
            ▤
        </div>

        <div>
            <span>Total Requests</span>
            <strong>12</strong>
        </div>

    </div>


    <div class="request-summary-card">

        <div class="request-summary-icon pending-icon">
            ◷
        </div>

        <div>
            <span>Pending</span>
            <strong>5</strong>
        </div>

    </div>


    <div class="request-summary-card">

        <div class="request-summary-icon progress-icon">
            ☷
        </div>

        <div>
            <span>In Progress</span>
            <strong>3</strong>
        </div>

    </div>

</div>


<!-- REQUEST LIST -->

<div class="request-management-card">

    <div class="request-management-header">

        <div>
            <h2>Citizen Requests</h2>

            <p>
                View submitted requests and review their current status.
            </p>
        </div>

    </div>


    <!-- REQUEST 1 -->

    <div class="request-item">

        <div class="request-item-main">

            <div class="request-item-icon">
                ▤
            </div>

            <div class="request-item-info">

                <h3>Barangay Certificate Request</h3>

                <p>
                    Request ID: REQ-001
                </p>

                <span>
                    Citizen: Juan Dela Cruz
                </span>

            </div>

        </div>


        <div class="request-item-right">

            <span class="request-status-badge pending">
                Pending
            </span>

            <a
                href="{{ route('personnel.request-details', ['id' => 'REQ-001']) }}"
                class="request-view-button">
                View Request
            </a>

        </div>

    </div>


    <!-- REQUEST 2 -->

    <div class="request-item">

        <div class="request-item-main">

            <div class="request-item-icon">
                ▤
            </div>

            <div class="request-item-info">

                <h3>Barangay Clearance Request</h3>

                <p>
                    Request ID: REQ-002
                </p>

                <span>
                    Citizen: Maria Santos
                </span>

            </div>

        </div>


        <div class="request-item-right">

            <span class="request-status-badge progress">
                In Progress
            </span>

            <a
                href="{{ route('personnel.request-details', ['id' => 'REQ-002']) }}"
                class="request-view-button">
                View Request
            </a>

        </div>

    </div>


    <!-- REQUEST 3 -->

    <div class="request-item">

        <div class="request-item-main">

            <div class="request-item-icon">
                ▤
            </div>

            <div class="request-item-info">

                <h3>Certificate of Residency</h3>

                <p>
                    Request ID: REQ-003
                </p>

                <span>
                    Citizen: Pedro Reyes
                </span>

            </div>

        </div>


        <div class="request-item-right">

            <span class="request-status-badge completed">
                Completed
            </span>

            <a
                href="{{ route('personnel.request-details', ['id' => 'REQ-003']) }}"
                class="request-view-button">
                View Request
            </a>

        </div>

    </div>

</div>

</div>

@endsection
