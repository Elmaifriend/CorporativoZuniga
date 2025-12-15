<?php

namespace App\Filament\Resources\Messages\Pages;

use App\Filament\Resources\Messages\MessageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Components\Tabs\Tab;


class ListMessages extends ListRecords
{
    protected static string $resource = MessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return auth()->user()->receivedMessages()->getQuery();
    }

    public function getTabs(): array
    {
        return [
            'received' => Tab::make('Recibidos')
                ->icon('heroicon-o-inbox')
                ->modifyQueryUsing(fn (Builder $query) =>
                    $query->whereHas('recipients', fn ($q) =>
                        $q->where('users.id', auth()->id())
                    )
                ),

            'sent' => Tab::make('Enviados')
                ->icon('heroicon-o-paper-airplane')
                ->modifyQueryUsing(fn (Builder $query) =>
                    $query->where('sender_id', auth()->id())
                ),

            'all' => Tab::make('Todos')
                ->icon('heroicon-o-archive-box'),
        ];
    }

    public function getDefaultActiveTab(): string
    {
        return 'received';
    }
}
