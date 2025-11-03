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
        \Log::info('Processing scheduled reminders...');
        $reminders = ScheduledReminder::where('is_active', true)->get();
        Log::info('Found ' . count($reminders) . ' reminders to process.');

        foreach ($reminders as $reminder) {
            Log::info($reminder);

            if ($this->shouldSendReminder($reminder)) {
                Log::info('Sending reminder for event: ' . $reminder->event->title);
                $participants = $reminder->event->participants()->get();

                $notificationService = new NotificationService();

                foreach ($participants as $participant) {
                    if ($participant->payment_status === $reminder->target_status) {
                        Log::info('Sending reminder for event: ' . $reminder->event->title);
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
            $sendDate = $event->event_date->copy()->subDays($daysBeforeEvent);

            $sendTime = $sendDate->setTime(9, 00, 0);
            $diff = Carbon::now()->diffInSeconds($sendTime, false);

            return ($diff >= 0);
        }

        return false;
    }
}
