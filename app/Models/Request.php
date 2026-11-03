<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Request extends Model
{
    protected $fillable = [
        'user_id',
        'guest_name',
        'guest_contact',
        'subject',
        'concern_text',
        'location',
        'reference_number',
        'category',
        'confidence',
        'status',
        'assigned_to',
    ];

    protected $casts = [
        'confidence' => 'decimal:4',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedPersonnel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}