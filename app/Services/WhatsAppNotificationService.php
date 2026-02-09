<?php

namespace App\Services;

use App\Models\Applicant;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;


class WhatsappApiNotificationService
{
    protected string $apiUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.url');
        $this->apiKey = config('services.whatsapp.key');

    }

    public function sendTemplate( $chatId, string $templateName, array $parameters = [], string $lang = "es" ): bool {
        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $chatId,
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => [
                    'code' => $lang,
                ],
            ],
        ];

        if ($parameters !== []) {
            $payload['template']['components'][] = [
                'type' => 'body',
                'parameters' => $this->buildNamedParameters($parameters),
            ];
        }

        $response = Http::withToken($this->apiKey)
            ->post("{$this->apiUrl}/messages", $payload);

        if ($response->failed()) {
            Log::error('Error enviando template WhatsApp', [
                'template' => $templateName,
                'payload' => $payload,
                'response' => $response->json(),
            ]);
            return false;
        }

        return true;
    }

    protected function buildNamedParameters(array $parameters): array
    {
        $result = [];

        foreach ($parameters as $name => $value) {
            $result[] = [
                'type' => 'text',
                'parameter_name' => $name,
                'text' => (string) $value,
            ];
        }

        return $result;
    }

}
