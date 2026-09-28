@extends('layouts.app')

@section('title', 'Personnel Reports')

@section('page-title', 'Personnel Reports')

@section('content')

<div class="personnel-reports">

<!-- PAGE HEADER -->

<div class="personnel-reports-header">

    <h1>Request Reports</h1>

    <p>
        View a summary of citizen requests and their current status.
    </p>

</div>


<!-- SUMMARY CARDS -->

<div class="report-summary">

    <div class="report-card">

        <div class="report-card-icon">
            ▤
        </div>

        <div>
            <span>Total Requests</span>
            <strong>48</strong>
        </div>

    </div>


    <div class="report-card">

        <div class="report-card-icon">
            ◷
        </div>

        <div>
            <span>Pending</span>
            <strong>12</strong>
        </div>

    </div>


    <div class="report-card">

        <div class="report-card-icon">
            ↻
        </div>

        <div>
            <span>In Progress</span>
            <strong>8</strong>
        </div>

    </div>


    <div class="report-card">

        <div class="report-card-icon">
            ✓
        </div>

        <div>
            <span>Resolved</span>
            <strong>28</strong>
        </div>

    </div>

</div>


<!-- REQUEST STATUS -->

<div class="report-section">

    <div class="report-section-header">

        <div>
            <h2>Request Status Overview</h2>

            <p>
                Current distribution of submitted citizen requests.
            </p>
        </div>

    </div>


    <div class="report-status-list">

        <!-- PENDING -->

        <div class="report-status-item">

            <div class="report-status-info">

                <span>Pending Requests</span>
                <strong>12 requests</strong>

            </div>

            <div class="report-progress">

                <div class="report-progress-bar pending"
                     style="width: 25%;">
                </div>

            </div>

        </div>


        <!-- IN PROGRESS -->

        <div class="report-status-item">

            <div class="report-status-info">

                <span>In Progress</span>
                <strong>8 requests</strong>

            </div>

            <div class="report-progress">

                <div class="report-progress-bar progress"
                     style="width: 17%;">
                </div>

            </div>

        </div>


        <!-- RESOLVED -->

        <div class="report-status-item">

            <div class="report-status-info">

                <span>Resolved</span>
                <strong>28 requests</strong>

            </div>

            <div class="report-progress">

                <div class="report-progress-bar completed"
                     style="width: 58%;">
                </div>

            </div>

        </div>

    </div>

</div>


<!-- REQUEST TYPES -->

<div class="report-section">

    <div class="report-section-header">

        <div>
            <h2>Request Types</h2>

            <p>
                Summary of the different services requested by citizens.
            </p>
        </div>

    </div>


    <div class="report-type-list">

        <div class="report-type-row">

            <span>Barangay Certificate</span>
            <strong>18</strong>

        </div>


        <div class="report-type-row">

            <span>Barangay Clearance</span>
            <strong>15</strong>

        </div>


        <div class="report-type-row">

            <span>Community Complaint</span>
            <strong>9</strong>

        </div>


        <div class="report-type-row">

            <span>Other Concerns</span>
            <strong>6</strong>

        </div>

    </div>

</div>


<!-- REPORT NOTE -->

<div class="report-note">

    <strong>Report Information</strong>

    <p>
        The figures shown on this page are currently sample data for
        interface development. They will be replaced with actual request
        records once the backend and database integration is completed.
    </p>

</div>

</div>

@endsection
