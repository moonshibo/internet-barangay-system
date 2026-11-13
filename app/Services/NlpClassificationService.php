<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class NlpClassificationService
{
    private const ALLOWED_CATEGORIES = [
        'Barangay Assistance',
        'Community Concern',
        'Noise Complaint',
        'Peace and Order Concern',
    ];

    public function classify(string $text): array
    {
        if (trim($text) === '' || mb_strlen($text) > 5000) {
            throw new RuntimeException('Invalid classification text.');
        }

        try {
            $response = Http::acceptJson()
                ->asJson()
                ->timeout(config('services.nlp.timeout', 5))
                ->post(config('services.nlp.url'), [
                    'text' => $text,
                ]);
        } catch (ConnectionException $exception) {
            throw new RuntimeException(
                'NLP service is unavailable or timed out.',
                0,
                $exception
            );
        }

        if (! $response->successful()) {
            throw new RuntimeException(
                'NLP service returned HTTP ' . $response->status()
            );
        }

        $data = $response->json();

        if (! is_array($data)) {
            throw new RuntimeException('NLP service returned invalid JSON.');
        }

        if (
            ! isset($data['category']) ||
            ! is_string($data['category']) ||
            ! in_array($data['category'], self::ALLOWED_CATEGORIES, true)
        ) {
            throw new RuntimeException(
                'NLP service returned an invalid category.'
            );
        }

        if (
            ! isset($data['confidence']) ||
            ! is_numeric($data['confidence']) ||
            ! is_finite((float) $data['confidence']) ||
            $data['confidence'] < 0 ||
            $data['confidence'] > 1
        ) {
            throw new RuntimeException(
                'NLP service returned invalid confidence.'
            );
        }

        return [
            'category' => $data['category'],
            'confidence' => (float) $data['confidence'],
        ];
    }
}