<?php

namespace App\Filament\Resources\Clients\Pages;

use App\Filament\Resources\Clients\ClientsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;



class ListClients extends ListRecords
{
    protected static string $resource = ClientsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->label("Todos"),
            'fisica' => Tab::make()
                ->label("Persona Fisica")
                ->modifyQueryUsing(fn (Builder $query) => $query->where('person_type', "persona_fisica")),
            'moral' => Tab::make()
                ->label("Persona Moral")
                ->modifyQueryUsing(fn (Builder $query) => $query->where('person_type', "persona_moral")),
            'prospecto' => Tab::make()
                ->label("Prospectos")
                ->modifyQueryUsing(fn (Builder $query) => $query->where('client_type', "prospecto")),
        ];
    }
}
