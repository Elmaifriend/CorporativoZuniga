<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAppointments extends ListRecords
{
    protected static string $resource = AppointmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'confirmed' => Tab::make()
                ->label("Confirmado")
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', "Confirmado")),
            'pending' => Tab::make()
                ->label("Pendiente")
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', "Pendiente")),
            'asisted' => Tab::make()
                ->label("Asistio")
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', "Asistio")),
            'canceled' => Tab::make()
                ->label("Cancelado")
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', "Cancelado")),
            'all' => Tab::make()
                ->label("Todos"),
        ];
    }
}
//Pendiente, Confirmada, Asistió, Canceló, Reagendó