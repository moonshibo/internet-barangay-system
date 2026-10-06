<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{
    public function store(HttpRequest $request)
{
    $validated = $request->validate([
        'subject' => ['required', 'string', 'max:255'],
        'concern_text' => ['required', 'string', 'max:5000'],
        'location' => ['nullable', 'string', 'max:255'],
    ]);

    Request::create([
        'user_id' => auth()->id(),
        'subject' => $validated['subject'],
        'concern_text' => $validated['concern_text'],
        'location' => $validated['location'] ?? null,
        'status' => 'Pending',
    ]);

    return redirect('/citizen/submit-request')
        ->with('success', 'Your concern has been submitted successfully.');
}
}