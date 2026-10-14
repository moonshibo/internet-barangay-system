<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    public function store(HttpRequest $request)
    {
        $validated = $request->validate([
            'category' => [
                'required',
                'string',
                'in:infrastructure,sanitation,health,public-safety,documents,other',
            ],
            'subject' => ['required', 'string', 'max:255'],
            'concern_text' => ['required', 'string', 'max:5000'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        do {
            $referenceNumber = 'BRGY-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Request::where('reference_number', $referenceNumber)->exists());

        Request::create([
            'user_id' => auth()->id(),
            'category' => $validated['category'],
            'subject' => $validated['subject'],
            'concern_text' => $validated['concern_text'],
            'location' => $validated['location'] ?? null,
            'reference_number' => $referenceNumber,
            'status' => 'Pending',
        ]);

        return redirect('/citizen/submit-request')
            ->with(
                'success',
                'Your concern has been submitted successfully. Your reference number is: ' . $referenceNumber
            );
    }

    public function storeGuest(HttpRequest $request)
    {
        $validated = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_contact' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'concern_text' => ['required', 'string', 'max:5000'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        do {
            $referenceNumber = 'BRGY-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Request::where('reference_number', $referenceNumber)->exists());

        Request::create([
            'user_id' => null,
            'guest_name' => $validated['guest_name'],
            'guest_contact' => $validated['guest_contact'],
            'subject' => $validated['subject'],
            'concern_text' => $validated['concern_text'],
            'location' => $validated['location'] ?? null,
            'reference_number' => $referenceNumber,
            'status' => 'Pending',
        ]);

        return redirect('/submit-request')
            ->with(
                'success',
                'Your concern has been submitted. Your reference number is: ' . $referenceNumber
            );
    }

    public function history()
    {
        $requests = auth()->user()
            ->requests()
            ->latest()
            ->get();

        return view('citizen.history', compact('requests'));
    }

    public function track(HttpRequest $request)
    {
        $referenceNumber = trim(
            (string) $request->query('reference_number', '')
        );

        $trackedRequest = null;
        $trackingMessage = null;

        if ($referenceNumber !== '') {
            $request->validate([
                'reference_number' => ['required', 'string', 'max:255'],
            ]);

            // Search only the authenticated citizen's own requests.
            $trackedRequest = auth()->user()
                ->requests()
                ->where('reference_number', strtoupper($referenceNumber))
                ->first();

            // Support older History references such as REQ-12.
            if (
                !$trackedRequest &&
                preg_match('/^REQ-(\d+)$/i', $referenceNumber, $matches)
            ) {
                $trackedRequest = auth()->user()
                    ->requests()
                    ->whereKey((int) $matches[1])
                    ->first();
            }

            if (!$trackedRequest) {
                $trackingMessage =
                    'No request was found for that reference number. Check the number and try again.';
            }
        }

        return view('citizen.track-request', compact(
            'trackedRequest',
            'trackingMessage',
            'referenceNumber'
        ));
    }
}