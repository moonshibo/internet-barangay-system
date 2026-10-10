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
        <strong>{{ $requests->count() }}</strong>
    </div>

    <div class="history-summary-item">
        <span>Under Review</span>
        <strong>{{ $requests->where('status', 'Under Review')->count() }}</strong>
    </div>

    <div class="history-summary-item">
        <span>Resolved</span>
        <strong>{{ $requests->where('status', 'Resolved')->count() }}</strong>
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

        @if ($requests->isEmpty())

            <div class="history-empty-state">
                <p>You have not submitted any concerns yet.</p>

                <a
                    href="{{ url('/citizen/submit-request') }}"
                    class="history-submit-button"
                >
                    Submit Your First Concern
                </a>
            </div>

        @else

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

                    @foreach ($requests as $request)

                        <tr>

                            <td>
                                <strong>
                                    {{ $request->reference_number ?? 'REQ-' . $request->id }}
                                </strong>
                            </td>

                            <td>
                                {{ $request->concern_text }}
                            </td>

                            <td>
                                {{ $request->category ?? '—' }}
                            </td>

                            <td>
                                {{ $request->created_at->format('F j, Y') }}
                            </td>

                            <td>

                                @php
                                    $statusClass = match ($request->status) {
                                        'Pending' => 'history-status-pending',
                                        'Under Review' => 'history-status-review',
                                        'Resolved' => 'history-status-resolved',
                                        default => 'history-status-review',
                                    };
                                @endphp

                                <span class="history-status {{ $statusClass }}">
                                    {{ $request->status }}
                                </span>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @endif

    </div>

</div>

</div>

@endsection
