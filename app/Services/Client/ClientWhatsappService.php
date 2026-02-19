<?php

namespace App\Services\Client;

use App\Models\Client;
use App\Services\WhatsappApiNotificationService;
use Illuminate\Support\Facades\URL;

class ClientWhatsappService
{
    public function __construct(
        protected WhatsappApiNotificationService $whatsapp
    ) {}

    public function sendEditProfileLink(Client $client): bool
    {
        $link = URL::temporarySignedRoute(
            'cliente.portal',
            now()->addHours(24),
            ['client' => $client->id]
        );

        return $this->whatsapp->sendTemplate(
            chatId: $client->phone_number,
            templateName: 'acceso_portal_cliente',
            parameters: [
                'nombre' => $client->full_name,
                'link' => $link,
            ],
            lang: 'es'
        );
    }

    public function requestDocuments(Client $client): bool
    {
        $link = URL::temporarySignedRoute(
            'cliente.documentos',
            now()->addHours(24),
            ['client' => $client->id]
        );

        return $this->whatsapp->sendTemplate(
            chatId: $client->phone_number,
            templateName: 'solicitud_documentos_cliente',
            parameters: [
                'nombre' => $client->full_name,
                'link_documentos' => $link,
            ],
            lang: 'es'
        );
    }
}
