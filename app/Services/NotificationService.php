<?php

namespace App\Services;

use App\Jobs\SendWhatsappBlastJob;
use GuzzleHttp\Client;
use App\Models\Participant;
use App\Models\BlastHistory;
use App\Models\ScheduledReminder;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function sendNotification(Participant $participant, ScheduledReminder $reminder): bool
    {
        try {
            $messageContent = $this->parseMessageTemplate($participant, $reminder);
            $phoneNumber = $this->formatPhoneNumber($participant->phone_number);

            $randomDelayInSeconds = mt_rand(1, 15);

            Log::info('delay: ' . $randomDelayInSeconds);

            dispatch(new SendWhatsappBlastJob($participant, $reminder))->delay(now()->addSeconds($randomDelayInSeconds));

            // Log success
            BlastHistory::create([
                'participant_id' => $participant->id,
                'scheduled_reminder_id' => $reminder->id,
                'message_content' => $messageContent,
                'channel' => 'whatsapp',
                'status' => 'sent',
                'sent_at' => now(),
            ]);
            return true;

        } catch (\Exception $e) {
            Log::error("Failed to send notification: " . $e->getMessage());

            BlastHistory::create([
                'participant_id' => $participant->id,
                'scheduled_reminder_id' => $reminder->id,
                'message_content' => $e->getMessage(),
                'channel' => 'whatsapp',
                'status' => 'failed',
                'sent_at' => now(),
            ]);

            return false;
        }
    }

    private function parseMessageTemplate(Participant $participant, ScheduledReminder $reminder): string
    {
        $template = $reminder->message_template;
        $event = $reminder->event;

        $message = str_replace('{participant_name}', $participant->name, $template);
        $message = str_replace('{event_title}', $event->title, $message);
        $message = str_replace('{event_date}', $event->event_date->format('d-m-Y H:i'), $message);

        return $message;
    }

    private function formatPhoneNumber(string $phone): string
    {
        $phone = str_replace([' ', '-'], '', $phone);

        if (strpos($phone, '08') === 0) {
            return '+62' . substr($phone, 1);
        }

        if (strpos($phone, '+62') === 0) {
            return $phone;
        }

        return $phone;
    }

}
