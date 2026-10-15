@extends('layouts.app')

@section('title', 'Submit Concern')

@section('page-title', 'Submit Concern')

@section('content')

<div class="request-page">

    <!-- PAGE HEADER -->

    <div class="request-header">

        <h2>Submit a Concern</h2>

        <p>
            Tell us about your concern and provide the details needed
            for barangay personnel to review your request.
        </p>

    </div>


    <!-- FORM CARD -->

    <div class="request-form-card">

        <form
            id="requestForm"
            method="POST"
            action="{{ url('/citizen/submit-request') }}"
        >
            @csrf

            @if ($errors->any())
                <div class="validation-notice" role="alert" aria-live="polite">
                    <strong>
                        <span aria-hidden="true">⚠</span>
                        Your request could not be submitted.
                    </strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- REQUEST TYPE -->

            <div class="form-group">

                <label for="requestType">
                    Concern Category
                </label>

                <select
                    id="requestType"
                    name="category"
                    required
                >

                    <option value="">
                        Select a concern category
                    </option>

                    <option value="infrastructure">
                        Infrastructure
                    </option>

                    <option value="sanitation">
                        Sanitation
                    </option>

                    <option value="health">
                        Health
                    </option>

                    <option value="public-safety">
                        Public Safety
                    </option>

                    <option value="documents">
                        Barangay Documents
                    </option>

                    <option value="other">
                        Other
                    </option>

                </select>

            </div>


            <!-- SUBJECT -->

            <div class="form-group">

                <label for="subject">
                    Subject
                </label>

                <input
                    type="text"
                    id="subject"
                    name="subject"
                    placeholder="Enter a short title for your concern"
                    maxlength="255"
                    value="{{ old('subject') }}"
                    required
                >

                <small id="subjectCounter" class="form-help" aria-live="polite">
                    0/255 characters
                </small>

                @error('subject')
                    <small class="field-error">{{ $message }}</small>
                @enderror

            </div>


            <!-- DESCRIPTION -->

            <div class="form-group">

                <label for="description">
                    Description
                </label>

                <textarea
                    id="description"
                    name="concern_text"
                    rows="6"
                    maxlength="5000"
                    placeholder="Describe your concern in detail..."
                    required
                    >{{ old('concern_text') }}</textarea>

                <small id="descriptionCounter" class="form-help" aria-live="polite">
                    0/5000 characters
                </small>

                <small class="form-help">
                    Please provide enough information to help barangay
                    personnel understand your concern.
                </small>

                @error('concern_text')
                    <small class="field-error">{{ $message }}</small>
                @enderror

            </div>


            <!-- LOCATION -->

            <div class="form-group">

                <label for="location">
                    Location
                </label>

                <input
                    type="text"
                    id="location"
                    name="location"
                    placeholder="Enter the location related to your concern"
                >

                <small class="form-help">
                    Example: Purok 3, Barangay Hall area
                </small>

            </div>


            <!-- ATTACHMENT -->

            <div class="form-group">

                <label for="attachment">
                    Attachment
                    <span class="optional-label">(Optional)</span>
                </label>

                <input
                    type="file"
                    id="attachment"
                    name="attachment"
                    class="file-input"
                >

                <small class="form-help">
                    You may attach a photo or document that can help
                    explain your concern.
                </small>

            </div>


            <!-- INFORMATION BOX -->

            <div class="submission-info">

                <div class="submission-info-icon">
                    i
                </div>

                <div>

                    <strong>Before you submit</strong>

                    <p>
                        Your concern will be reviewed by barangay
                        personnel. You can track its status from the
                        Track Request page after submission.
                    </p>

                </div>

            </div>


            <!-- FORM ACTIONS -->

            <div class="form-actions">

                <a
                    href="{{ url('/citizen/dashboard-preview') }}"
                    class="button button-secondary"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="button button-primary"
                >
                    Submit Concern
                </button>

            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const requestForm = document.getElementById('requestForm');

    if (requestForm) {
        requestForm.addEventListener('submit', function (event) {
            const confirmed = confirm(
                'Are you sure you want to submit this request?'
            );

            if (!confirmed) {
                event.preventDefault();
            }
        });
    }

    const counters = [
        {
            input: document.getElementById('subject'),
            counter: document.getElementById('subjectCounter'),
            limit: 255
        },
        {
            input: document.getElementById('description'),
            counter: document.getElementById('descriptionCounter'),
            limit: 5000
        }
    ];

    counters.forEach(function (item) {
        if (!item.input || !item.counter) return;

        function updateCounter() {
            const count = item.input.value.length;

            item.counter.textContent =
                `${count}/${item.limit} characters`;

            item.counter.style.color =
                count >= item.limit ? '#B42318' : '';

            item.counter.style.fontWeight =
                count >= item.limit ? '600' : '';
        }

        item.input.addEventListener('input', updateCounter);
        updateCounter();
    });
});
</script>
@endpush