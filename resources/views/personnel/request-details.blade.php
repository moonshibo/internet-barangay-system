@extends('layouts.app')

@section('title', 'Request Details')

@section('page-title', 'Request Details')

@section('content')

<div class="request-details-page">

    {{-- =========================================
         PAGE HEADER
         ========================================= --}}

    <div class="request-details-header">

        <div>

            <a href="{{ url('/personnel/requests') }}" class="back-button">
                ← Back to Manage Requests
            </a>

            <h1>Request Details</h1>

            <p>
                Review the submitted request and update its status.
            </p>

        </div>

        <span
            id="headerStatusBadge"
            class="details-status pending"
        >
            Pending
        </span>

    </div>


    {{-- =========================================
         REQUEST DETAILS GRID
         ========================================= --}}

    <div class="request-details-grid">


        {{-- =====================================
             MAIN REQUEST INFORMATION
             ===================================== --}}

        <div class="request-details-main">

            <div class="details-card">

                {{-- Request Header --}}

                <div class="details-card-header">

                    <div>

                        <span class="details-label">
                            Request ID
                        </span>

                        <h2>
                            REQ-0001
                        </h2>

                    </div>

                    <span class="details-type">
                        Barangay Certificate
                    </span>

                </div>


                {{-- Citizen Information --}}

                <div class="details-section">

                    <h3>
                        Citizen Information
                    </h3>

                    <div class="details-info-grid">

                        <div class="details-info">

                            <span>
                                Full Name
                            </span>

                            <strong>
                                Juan Dela Cruz
                            </strong>

                        </div>


                        <div class="details-info">

                            <span>
                                Contact Number
                            </span>

                            <strong>
                                0912 345 6789
                            </strong>

                        </div>


                        <div class="details-info">

                            <span>
                                Email Address
                            </span>

                            <strong>
                                juan@example.com
                            </strong>

                        </div>


                        <div class="details-info">

                            <span>
                                Address
                            </span>

                            <strong>
                                Barangay Sample, Taytay
                            </strong>

                        </div>

                    </div>

                </div>


                <div class="details-divider"></div>


                {{-- Request Information --}}

                <div class="details-section">

                    <h3>
                        Request Information
                    </h3>

                    <div class="details-info-grid">

                        <div class="details-info">

                            <span>
                                Request Type
                            </span>

                            <strong>
                                Barangay Certificate
                            </strong>

                        </div>


                        <div class="details-info">

                            <span>
                                Date Submitted
                            </span>

                            <strong>
                                September 25, 2026
                            </strong>

                        </div>


                        <div class="details-info full-width">

                            <span>
                                Concern / Description
                            </span>

                            <p>
                                The citizen is requesting a barangay
                                certificate for documentation purposes.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================
             RIGHT SIDEBAR
             ===================================== --}}

        <div class="request-details-side">


            {{-- =================================
                 REQUEST STATUS
                 ================================= --}}

            <div class="details-card request-status-card">

                <h3>
                    Request Status
                </h3>


                {{-- Current Status --}}

                <div class="request-current-status">

                    <span
                        id="currentStatusBadge"
                        class="details-status pending"
                    >
                        Pending
                    </span>

                    <p id="statusMessage">
                        Waiting for personnel review.
                    </p>

                </div>


                {{-- Update Status --}}

                <div class="request-status-update">

                    <label for="request-status">
                        Update Status
                    </label>

                    <select id="request-status">

                        <option value="pending">
                            Pending
                        </option>

                        <option value="review">
                            Under Review
                        </option>

                        <option value="resolved">
                            Resolved
                        </option>

                    </select>


                    <button
                        type="button"
                        id="updateStatusButton"
                        class="update-status-button"
                    >
                        Update Status
                    </button>

                </div>

            </div>


            {{-- =================================
                 REQUEST TIMELINE
                 ================================= --}}

            <div class="details-card request-timeline-card">

                <h3>
                    Request Timeline
                </h3>


                <div class="request-timeline">


                    {{-- Submitted --}}

                    <div
                        id="timelineSubmitted"
                        class="request-timeline-item active"
                    >

                        <div class="request-timeline-dot"></div>

                        <div class="request-timeline-content">

                            <strong>
                                Request Submitted
                            </strong>

                            <span>
                                September 25, 2026
                            </span>

                        </div>

                    </div>


                    {{-- Under Review --}}

                    <div
                        id="timelineProgress"
                        class="request-timeline-item"
                    >

                        <div class="request-timeline-dot"></div>

                        <div class="request-timeline-content">

                            <strong>
                                Under Review
                            </strong>

                            <span id="progressTimelineText">
                                Waiting for personnel action
                            </span>

                        </div>

                    </div>


                    {{-- Completed --}}

                    <div
                        id="timelineCompleted"
                        class="request-timeline-item"
                    >

                        <div class="request-timeline-dot"></div>

                        <div class="request-timeline-content">

                            <strong>
                                Completed
                            </strong>

                            <span id="completedTimelineText">
                                Not yet completed
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


{{-- =============================================
     REQUEST DETAILS INTERACTION
     ============================================= --}}

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const statusSelect = document.getElementById('request-status');
    const updateButton = document.getElementById('updateStatusButton');

    const statusBadge = document.getElementById('currentStatusBadge');
    const headerStatusBadge = document.getElementById('headerStatusBadge');
    const statusMessage = document.getElementById('statusMessage');

    const timelineSubmitted = document.getElementById('timelineSubmitted');
    const timelineProgress = document.getElementById('timelineProgress');
    const timelineCompleted = document.getElementById('timelineCompleted');

    const progressTimelineText = document.getElementById('progressTimelineText');
    const completedTimelineText = document.getElementById('completedTimelineText');


    function updateTimeline(selectedStatus) {

        // Reset all timeline classes
        timelineSubmitted.classList.remove('active', 'completed-step');
        timelineProgress.classList.remove('active', 'completed-step');
        timelineCompleted.classList.remove('active', 'completed-step');


        /*
         * =========================================
         * PENDING
         * =========================================
         *
         * ● Request Submitted
         * │ gray
         * ○ Under Review
         * │ gray
         * ○ Resolved
         */

        if (selectedStatus === 'pending') {

            timelineSubmitted.classList.add('active');

            progressTimelineText.textContent =
                'Waiting for personnel action';

            completedTimelineText.textContent =
                'Not yet resolved';
        }


        /*
         * =========================================
         * UNDER REVIEW
         * =========================================
         *
         * ● Request Submitted
         * │ blue
         * ● Under Review
         * │ gray
         * ○ Resolved
         */

        else if (selectedStatus === 'review') {

            timelineSubmitted.classList.add(
                'active',
                'completed-step'
            );

            timelineProgress.classList.add('active');

            progressTimelineText.textContent =
                'Personnel is currently reviewing the request';

            completedTimelineText.textContent =
                'Not yet resolved';
        }


        /*
         * =========================================
         * RESOLVED
         * =========================================
         *
         * ● Request Submitted
         * │ blue
         * ● Under Review
         * │ blue
         * ● Resolved
         */

        else if (selectedStatus === 'resolved') {

            timelineSubmitted.classList.add(
                'active',
                'completed-step'
            );

            timelineProgress.classList.add(
                'active',
                'completed-step'
            );

            timelineCompleted.classList.add('active');

            progressTimelineText.textContent =
                'Request was reviewed and processed';

            completedTimelineText.textContent =
                'Request resolved successfully';
        }
    }


    /*
     * =========================================
     * UPDATE STATUS BUTTON
     * =========================================
     */

    updateButton.addEventListener('click', function () {

        const selectedStatus = statusSelect.value;


        /* PENDING */

        if (selectedStatus === 'pending') {

            statusBadge.textContent = 'Pending';
            headerStatusBadge.textContent = 'Pending';

            statusBadge.className =
                'details-status pending';

            headerStatusBadge.className =
                'details-status pending';

            statusMessage.textContent =
                'Waiting for personnel review.';
        }


        /* UNDER REVIEW */

        else if (selectedStatus === 'review') {

            statusBadge.textContent = 'Under Review';
            headerStatusBadge.textContent = 'Under Review';

            statusBadge.className =
                'details-status progress';

            headerStatusBadge.className =
                'details-status progress';

            statusMessage.textContent =
                'This request is currently being reviewed by personnel.';
        }


        /* RESOLVED */

        else if (selectedStatus === 'resolved') {

            statusBadge.textContent = 'Resolved';
            headerStatusBadge.textContent = 'Resolved';

            statusBadge.className =
                'details-status completed';

            headerStatusBadge.className =
                'details-status completed';

            statusMessage.textContent =
                'This request has been resolved.';
        }


        // Update the timeline after changing the status
        updateTimeline(selectedStatus);
    });


    /*
     * =========================================
     * INITIAL TIMELINE STATE
     * =========================================
     */

    updateTimeline(statusSelect.value);

});
</script>
@endpush