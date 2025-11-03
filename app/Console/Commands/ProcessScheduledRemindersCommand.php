<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\ScheduledReminder;
use Illuminate\Support\Facades\Log;
use App\Services\NotificationService;
use App\Jobs\ProcessScheduledReminders;

class ProcessScheduledRemindersCommand extends Command
{
    protected $signature = 'check:scheduled-reminders';

    protected $description = 'Process scheduled reminders';

    public function handle()
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

                $reminder->update(['is_active' => false]);
            }
        }
    }

    private function shouldSendReminder(ScheduledReminder $reminder): bool
    {
        $event = $reminder->event;
        $scheduleSetting = $reminder->schedule_setting;

        // Parse schedule setting (e.g., 'H-3', 'H-1', 'H-0')
        if (preg_match('/H-(\d+)/', $scheduleSetting, $matches)) {
            $daysBeforeEvent = intval($matches[1]);
            $sendTime = $event->event_date->copy()->subDays($daysBeforeEvent);

            $diff = Carbon::now('Asia/Jakarta')->diffInSeconds($sendTime, false);

            $diffBetweenUTCAndJakarta = 7 * 60 * 60;

            $diff -= $diffBetweenUTCAndJakarta;

            return ($diff >= 0 && $diff <= 500);
        }

        return false;
    }
}
