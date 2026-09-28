@extends('layouts.app')

@section('title', 'Request History')

@section('page-title', 'Request History')

@section('content')

<div class="history-page">

    <!-- PAGE HEADER -->
    <div class="history-header">
        <h1>Request History</h1>

        <p>
            View your previous barangay service requests and their current status.
        </p>
    </div>


    <!-- HISTORY SUMMARY -->
    <div class="history-summary">

        <div class="history-summary-item">
            <span>Total Requests</span>
            <strong>3</strong>
        </div>

        <div class="history-summary-item">
            <span>Under Review</span>
            <strong>1</strong>
        </div>

        <div class="history-summary-item">
            <span>Resolved</span>
            <strong>1</strong>
        </div>

    </div>


    <!-- REQUEST HISTORY -->
    <div class="history-card">

        <div class="history-card-header">

            <div>
                <h2>Your Requests</h2>

                <p>
                    A record of your submitted barangay concerns.
                </p>
            </div>

            <a
                href="{{ url('/citizen/submit-request') }}"
                class="history-submit-button"
            >
                + Submit Concern
            </a>

        </div>


        <div class="history-table-wrapper">

            <table class="history-table">

                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Concern</th>
                        <th>Category</th>
                        <th>Date Submitted</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>
                            <strong>REQ-001</strong>
                        </td>

                        <td>
                            Street Light
                        </td>

                        <td>
                            Infrastructure
                        </td>

                        <td>
                            September 28, 2026
                        </td>

                        <td>
                            <span class="history-status history-status-pending">
                                Pending
                            </span>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <strong>REQ-002</strong>
                        </td>

                        <td>
                            Garbage Collection
                        </td>

                        <td>
                            Sanitation
                        </td>

                        <td>
                            September 27, 2026
                        </td>

                        <td>
                            <span class="history-status history-status-review">
                                Under Review
                            </span>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <strong>REQ-003</strong>
                        </td>

                        <td>
                            Barangay Clearance
                        </td>

                        <td>
                            Barangay Documents
                        </td>

                        <td>
                            September 25, 2026
                        </td>

                        <td>
                            <span class="history-status history-status-resolved">
                                Resolved
                            </span>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection