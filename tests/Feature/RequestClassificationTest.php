<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RequestClassificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_submission_saves_valid_classification(): void
    {
        Http::fake([
            '*' => Http::response([
                'category' => 'Peace and Order Concern',
                'confidence' => 0.42853032,
            ], 200),
        ]);

        $response = $this->post('/submit-request', [
            'guest_name' => 'Test Guest',
            'guest_contact' => '09123456789',
            'subject' => 'Noise at night',
            'concern_text' => 'Neighbors play loud music every night.',
            'location' => 'Test Street',
        ]);

        $response->assertRedirect('/submit-request');

        $this->assertDatabaseHas('requests', [
            'guest_name' => 'Test Guest',
            'subject' => 'Noise at night',
            'category' => 'Peace and Order Concern',
            'status' => 'Pending',
        ]);

        $storedConfidence = \Illuminate\Support\Facades\DB::table('requests')
            ->where('guest_name', 'Test Guest')
            ->value('confidence');

        $this->assertEqualsWithDelta(
            0.4285,
            (float) $storedConfidence,
            0.0001
        );

        $this->assertDatabaseCount('requests', 1);
    }

    public function test_guest_submission_is_preserved_when_nlp_returns_503(): void
    {
        Http::fake([
            '*' => Http::response([
                'error' => [
                    'code' => 'SERVICE_UNAVAILABLE',
                    'message' => 'NLP service unavailable.',
                ],
            ], 503),
        ]);

        $response = $this->post('/submit-request', [
            'guest_name' => 'Test Guest',
            'guest_contact' => '09123456789',
            'subject' => 'Street concern',
            'concern_text' => 'There is a problem on our street.',
            'location' => 'Test Street',
        ]);

        $response->assertRedirect('/submit-request');

        $this->assertDatabaseHas('requests', [
            'guest_name' => 'Test Guest',
            'subject' => 'Street concern',
            'category' => null,
            'confidence' => null,
            'status' => 'pending_classification',
        ]);

        $this->assertDatabaseCount('requests', 1);
    }

    public function test_authenticated_citizen_submission_saves_valid_classification(): void
    {
        $citizen = User::factory()->create([
            'role' => 'citizen',
        ]);

        Http::fake([
            '*' => Http::response([
                'category' => 'Community Concern',
                'confidence' => 0.7654,
            ], 200),
        ]);

        $response = $this->actingAs($citizen)->post(
            '/citizen/submit-request',
            [
                'subject' => 'Community concern',
                'concern_text' => 'There is an issue in our neighborhood.',
                'location' => 'Test Street',
            ]
        );

        $response->assertRedirect('/citizen/submit-request');

        $this->assertDatabaseHas('requests', [
            'user_id' => $citizen->id,
            'subject' => 'Community concern',
            'category' => 'Community Concern',
            'confidence' => '0.7654',
            'status' => 'Pending',
        ]);

        $this->assertDatabaseCount('requests', 1);
    }

    public function test_authenticated_citizen_submission_is_preserved_when_nlp_fails(): void
    {
        $citizen = User::factory()->create([
            'role' => 'citizen',
        ]);

        Http::fake([
            '*' => Http::response([
                'error' => [
                    'code' => 'SERVICE_UNAVAILABLE',
                    'message' => 'NLP service unavailable.',
                ],
            ], 503),
        ]);

        $response = $this->actingAs($citizen)->post(
            '/citizen/submit-request',
            [
                'subject' => 'Unclassified concern',
                'concern_text' => 'The classification service is unavailable.',
                'location' => 'Test Street',
            ]
        );

        $response->assertRedirect('/citizen/submit-request');

        $this->assertDatabaseHas('requests', [
            'user_id' => $citizen->id,
            'subject' => 'Unclassified concern',
            'category' => null,
            'confidence' => null,
            'status' => 'pending_classification',
        ]);

        $this->assertDatabaseCount('requests', 1);
    }

    public function test_guest_submission_is_preserved_when_nlp_connection_fails(): void
    {
        Http::fake(function () {
            throw new ConnectionException('Simulated connection failure.');
        });

        $response = $this->post('/submit-request', [
            'guest_name' => 'Test Guest',
            'guest_contact' => '09123456789',
            'subject' => 'Connection failure concern',
            'concern_text' => 'The classification service cannot be reached.',
            'location' => 'Test Street',
        ]);

        $response->assertRedirect('/submit-request');

        $this->assertDatabaseHas('requests', [
            'guest_name' => 'Test Guest',
            'subject' => 'Connection failure concern',
            'category' => null,
            'confidence' => null,
            'status' => 'pending_classification',
        ]);

        $this->assertDatabaseCount('requests', 1);
    }

    public function test_guest_submission_is_preserved_when_nlp_returns_invalid_category(): void
    {
        Http::fake([
            '*' => Http::response([
                'category' => 'Unknown Category',
                'confidence' => 0.85,
            ], 200),
        ]);

        $response = $this->post('/submit-request', [
            'guest_name' => 'Test Guest',
            'guest_contact' => '09123456789',
            'subject' => 'Invalid classification',
            'concern_text' => 'This is a test concern.',
            'location' => 'Test Street',
        ]);

        $response->assertRedirect('/submit-request');

        $this->assertDatabaseHas('requests', [
            'guest_name' => 'Test Guest',
            'subject' => 'Invalid classification',
            'category' => null,
            'confidence' => null,
            'status' => 'pending_classification',
        ]);

        $this->assertDatabaseCount('requests', 1);
    }

    public function test_guest_submission_is_preserved_when_nlp_returns_invalid_confidence(): void
    {
        Http::fake([
            '*' => Http::response([
                'category' => 'Community Concern',
                'confidence' => 1.5,
            ], 200),
        ]);

        $response = $this->post('/submit-request', [
            'guest_name' => 'Test Guest',
            'guest_contact' => '09123456789',
            'subject' => 'Invalid confidence',
            'concern_text' => 'This is a test concern.',
            'location' => 'Test Street',
        ]);

        $response->assertRedirect('/submit-request');

        $this->assertDatabaseHas('requests', [
            'guest_name' => 'Test Guest',
            'subject' => 'Invalid confidence',
            'category' => null,
            'confidence' => null,
            'status' => 'pending_classification',
        ]);

        $this->assertDatabaseCount('requests', 1);
    }

    public function test_guest_submission_is_preserved_when_nlp_returns_malformed_json(): void
    {
        Http::fake([
            '*' => Http::response(
                '{"category": "Community Concern", "confidence": ',
                200
            ),
        ]);

        $response = $this->post('/submit-request', [
            'guest_name' => 'Test Guest',
            'guest_contact' => '09123456789',
            'subject' => 'Malformed response',
            'concern_text' => 'This is a test concern.',
            'location' => 'Test Street',
        ]);

        $response->assertRedirect('/submit-request');

        $this->assertDatabaseHas('requests', [
            'guest_name' => 'Test Guest',
            'subject' => 'Malformed response',
            'category' => null,
            'confidence' => null,
            'status' => 'pending_classification',
        ]);

        $this->assertDatabaseCount('requests', 1);
    }
}