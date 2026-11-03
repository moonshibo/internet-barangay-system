<?php

namespace Tests\Feature;

use App\Models\Request as CitizenRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequestTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_citizen_can_track_their_own_request(): void
    {
        $citizen = User::factory()->create([
            'role' => 'citizen',
        ]);

        $request = CitizenRequest::create([
            'user_id' => $citizen->id,
            'subject' => 'Streetlight repair',
            'concern_text' => 'The streetlight is not working.',
            'reference_number' => 'BRGY-20261013-ABC123',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($citizen)->post(
            '/citizen/track-request',
            ['reference_number' => $request->reference_number]
        );

        $response->assertOk();
        $response->assertSee($request->reference_number);
        $response->assertSee('Streetlight repair');
    }

    public function test_citizen_cannot_track_another_citizens_request(): void
    {
        $owner = User::factory()->create([
            'role' => 'citizen',
        ]);

        $otherCitizen = User::factory()->create([
            'role' => 'citizen',
        ]);

        $request = CitizenRequest::create([
            'user_id' => $owner->id,
            'subject' => 'Private request subject',
            'concern_text' => 'Private request details.',
            'reference_number' => 'BRGY-20261013-XYZ789',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($otherCitizen)
            ->from('/citizen/track-request')
            ->post('/citizen/track-request', [
                'reference_number' => $request->reference_number,
            ]);

        $response->assertRedirect('/citizen/track-request');
        $response->assertSessionHasErrors('reference_number');
        $response->assertSessionHasInput(
            'reference_number',
            $request->reference_number
        );

        $response->assertSessionDoesntHaveErrors('subject');
    }

    public function test_guest_cannot_submit_a_request_tracking_search(): void
    {
        $response = $this->post('/citizen/track-request', [
            'reference_number' => 'BRGY-20261013-ABC123',
        ]);

        $response->assertRedirect('/login');
    }
}
