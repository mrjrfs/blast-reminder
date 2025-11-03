<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParticipantImport extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'file_name',
        'total_rows',
        'imported_rows',
        'failed_rows',
        'failed_data',
        'status',
        'error_message',
    ];

    protected $casts = [
        'failed_data' => 'array',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
