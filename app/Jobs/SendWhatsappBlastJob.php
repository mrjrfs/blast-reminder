<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendWhatsappBlastJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $participant;
    private $reminder;

    public function __construct($participant, $reminder)
    {
        $this->participant = $participant;
        $this->reminder = $reminder;
    }

    public function handle(): void
    {
        $this->sendViaWhatsApp($this->participant->phone_number, $this->reminder->message_template);
    }

    private function sendViaWhatsApp(string $phoneNumber, string $message): void
    {
        $token = env('WHATSAPP_NOTIFICATION_TOKEN');

        $client = new Client([
            'base_uri' => env('WHATSAPP_NOTIFICATION_ENDPOINT'),
            'timeout' => 10.0,
        ]);

        try {
            $response = $client->post('', [
                'headers' => [
                    'Authorization' => $token,
                ],
                'form_params' => [
                    'isi_pesan' => $message,
                    'nomor_recieved' => $phoneNumber
                ],
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $status = $response ? $response->getStatusCode() : 500;
        }
    }
}
