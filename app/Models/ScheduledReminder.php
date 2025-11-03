<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'message_template',
        'type',
        'target_status',
        'schedule_setting',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
