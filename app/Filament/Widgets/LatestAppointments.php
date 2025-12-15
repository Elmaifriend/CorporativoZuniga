<?php

namespace App\Filament\Widgets;

use App\Models\Appointments;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Colors\Color; // Importación necesaria para referencias de color

class LatestAppointments extends TableWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Appointments::query())
            ->columns([
                TextColumn::make('date_time')
                    ->dateTime()
                    ->label("Fecha y hora"),
                
                // CAMBIO 1: Usar 'primary' para el badge del responsable
                TextColumn::make('responsable.name') 
                    ->label("Responsable")
                    ->badge()
                    ->color("primary") // Usamos el color corporativo para la identificación
                    ->searchable() 
                    ->sortable(), 
                    
                TextColumn::make("status")
                    ->label("Estatus")
                    ->badge()
                    // Mantenemos los colores funcionales estándar para el estatus
                    ->color(fn (string $state): string => match ($state) {
                        'Confirmado' => 'success',
                        'Cancelada' => 'danger',
                        'Pendiente' => 'warning',
                        default => 'gray'
                    }),
                
                TextColumn::make("modality")
                    ->label("Modalidad")
                    ->badge()
                    // CAMBIO 2: Usar 'primary' para la modalidad 'Online' y/o 'Presencial'
                    ->color(fn (string $state): string => match ($state) {
                        'Online' => 'info', // Opcionalmente, puedes dejar 'info' si quieres un azul más claro
                        'Presencial' => 'primary', // Usamos el color corporativo para la modalidad principal
                        'Llamada' => 'purple',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}