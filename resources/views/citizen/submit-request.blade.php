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

        <form id="requestForm">

            <!-- REQUEST TYPE -->

            <div class="form-group">

                <label for="requestType">
                    Concern Category
                </label>

                <select
                    id="requestType"
                    name="requestType"
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
                    required
                >

            </div>


            <!-- DESCRIPTION -->

            <div class="form-group">

                <label for="description">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    placeholder="Describe your concern in detail..."
                    required
                ></textarea>

                <small class="form-help">
                    Please provide enough information to help barangay
                    personnel understand your concern.
                </small>

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