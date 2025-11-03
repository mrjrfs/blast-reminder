<?php

namespace App\Jobs;

use App\Models\ScheduledReminder;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class ProcessScheduledReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $reminders = ScheduledReminder::where('is_active', true)->get();

        foreach ($reminders as $reminder) {
            if ($this->shouldSendReminder($reminder)) {
                $participants = $reminder->event->participants()->get();

                $notificationService = new NotificationService();

                foreach ($participants as $participant) {
                    if ($participant->payment_status === $reminder->target_status) {
                        $notificationService->sendNotification($participant, $reminder);
                    }
                }
            }

            $reminder->update(['is_active' => false]);
        }
    }

    private function shouldSendReminder(ScheduledReminder $reminder): bool
    {
        $event = $reminder->event;
        $scheduleSetting = $reminder->schedule_setting;

        // Parse schedule setting (e.g., 'H-3', 'H-1', 'H-0')
        if (preg_match('/H-(\d+)/', $scheduleSetting, $matches)) {
            $hoursBeforeEvent = intval($matches[1]);
            $sendTime = $event->event_date->copy()->subHours($hoursBeforeEvent);

            return Carbon::now()->diffInSeconds($sendTime, false) <= 300;
        }

        return false;
    }
}
