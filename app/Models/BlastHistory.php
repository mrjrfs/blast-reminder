<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlastHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'scheduled_reminder_id',
        'message_content',
        'channel',
        'status',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function scheduledReminder(): BelongsTo
    {
        return $this->belongsTo(ScheduledReminder::class);
    }
}
