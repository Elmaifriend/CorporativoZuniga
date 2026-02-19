<?php

namespace App\Filament\Resources\Clients\Pages;

use App\Filament\Resources\Clients\ClientsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use App\Services\Client\ClientWhatsappService;
use Filament\Actions\ActionGroup;
use Illuminate\Support\Facades\URL;




class EditClients extends EditRecord
{
    protected static string $resource = ClientsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //ViewAction::make(),

            DeleteAction::make()
                ->link()
                ->icon('heroicon-o-trash'),

            Action::make('convertirACliente')
                ->label('Convertir a cliente')
                ->icon('heroicon-o-arrow-path')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->client_type === 'prospecto')
                ->action(function () {
                    $this->record->update([
                        'client_type' => 'cliente',
                    ]);

                    $this->refreshFormData([
                        'client_type',
                    ]);

                    Notification::make()
                        ->title('Convertido a cliente')
                        ->success()
                        ->send();
                }),
    
            ActionGroup::make([
                Action::make('copiarLinkDocumentos')
                    ->label('Copiar link')
                    ->icon('heroicon-o-clipboard')
                    ->action(function () {

                        $link = URL::temporarySignedRoute(
                            'cliente.documentos',
                            now()->addHours(24),
                            ['client' => $this->record->id]
                        );

                        $this->js("
                            navigator.clipboard.writeText('{$link}');
                        ");

                        Notification::make()
                            ->title("Copiado correctamente!")
                            ->success()
                            ->send();
                    }),

                Action::make('mandarLinkDocumentos')
                    ->label('Mandar por WhatsApp')
                    ->icon('heroicon-o-paper-airplane')
                    ->action(function (ClientWhatsappService $service) {

                        $sent = $service->requestDocuments($this->record);

                        Notification::make()
                            ->title(
                                $sent
                                    ? 'Solicitud enviada correctamente'
                                    : 'Error al enviar'
                            )
                            ->success($sent)
                            ->danger(! $sent)
                            ->send();
                    }),

            ])
            ->button()
            ->label('Pedir documentos')
            ->icon('heroicon-o-document-text')
            ->color('primary')
            ->visible(fn () => $this->record->client_type === 'cliente'),

            ActionGroup::make([
                Action::make('copiarLinkEditarPerfil')
                    ->label('Copiar link')
                    ->icon('heroicon-o-clipboard')
                    ->action(function () {

                        $link = URL::temporarySignedRoute(
                            'cliente.editar-perfil',
                            now()->addHours(24),
                            ['client' => $this->record->id]
                        );

                        $this->js("
                            navigator.clipboard.writeText('{$link}');
                            \$dispatch('notify', {
                                type: 'success',
                                title: 'Link copiado al portapapeles'
                            });
                        ");
                    }),
                Action::make('mandarLinkEditarPerfil')
                    ->label('Mandar por WhatsApp')
                    ->icon('heroicon-o-paper-airplane')
                    ->requiresConfirmation()
                    ->action(function (ClientWhatsappService $service) {

                        $sent = $service->sendEditProfileLink($this->record);

                        Notification::make()
                            ->title(
                                $sent
                                    ? 'Link enviado correctamente'
                                    : 'Error al enviar el mensaje'
                            )
                            ->success($sent)
                            ->danger(! $sent)
                            ->send();
                    }),
            ])
            ->button()
            ->label('Editar Perfil')
            ->icon('heroicon-o-user')
            ->color('primary')
            ->visible(fn () => $this->record->client_type === 'cliente'),
        ];
    }
}
