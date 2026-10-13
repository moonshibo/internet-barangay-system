<?php

namespace Tests\Feature;

use App\Models\Request as CitizenRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubmitGuestConcernTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_a_concern_and_receive_a_reference_number(): void
    {
        $response = $this->post('/submit-request', [
            'guest_name' => 'Test Guest',
            'guest_contact' => '09123456789',
            'subject' => 'Uncollected garbage',
            'concern_text' => 'Garbage has not been collected for several days.',
            'location' => '',
        ]);

        $response->assertRedirect('/submit-request');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('requests', [
            'user_id' => null,
            'guest_name' => 'Test Guest',
            'guest_contact' => '09123456789',
            'subject' => 'Uncollected garbage',
            'location' => null,
            'status' => 'Pending',
        ]);

        $savedRequest = CitizenRequest::where('guest_name', 'Test Guest')->first();

        $this->assertNotNull($savedRequest);
        $this->assertMatchesRegularExpression(
            '/^BRGY-\d{8}-[A-Z0-9]{6}$/',
            $savedRequest->reference_number
        );
    }

    public function test_guest_subject_cannot_exceed_255_characters(): void
    {
        $response = $this->from('/submit-request')->post('/submit-request', [
            'guest_name' => 'Test Guest',
            'guest_contact' => '09123456789',
            'subject' => str_repeat('A', 256),
            'concern_text' => 'A valid concern description.',
            'location' => '',
        ]);

        $response->assertRedirect('/submit-request');
        $response->assertSessionHasErrors('subject');

        $this->assertDatabaseCount('requests', 0);
    }

    public function test_guest_concern_description_cannot_exceed_5000_characters(): void
    {
        $response = $this->from('/submit-request')->post('/submit-request', [
            'guest_name' => 'Test Guest',
            'guest_contact' => '09123456789',
            'subject' => 'Validation Test',
            'concern_text' => str_repeat('A', 5001),
            'location' => '',
        ]);

        $response->assertRedirect('/submit-request');
        $response->assertSessionHasErrors('concern_text');

        $this->assertDatabaseCount('requests', 0);
    }

    public function test_guest_submission_requires_name_contact_subject_and_description(): void
    {
        $response = $this->from('/submit-request')->post('/submit-request', [
            'guest_name' => '',
            'guest_contact' => '',
            'subject' => '',
            'concern_text' => '',
            'location' => '',
        ]);

        $response->assertRedirect('/submit-request');
        $response->assertSessionHasErrors([
            'guest_name',
            'guest_contact',
            'subject',
            'concern_text',
        ]);

        $this->assertDatabaseCount('requests', 0);
    }
}
