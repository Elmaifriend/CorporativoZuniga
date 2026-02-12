<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Enums\RecordActionsPosition;


class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Documentación Digital';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Clasificación del Documento')
                    ->schema([
                        Select::make('document_name')
                            ->label('Tipo de Documento')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->options([
                                'Identidad' => [
                                    'acta_nacimiento' => 'Acta de nacimiento',
                                    'pasaporte' => 'Pasaporte',
                                    'curp' => 'CURP',
                                    'identificacion_oficial' => 'Identificación oficial',
                                    'acta_matrimonio' => 'Acta de matrimonio',
                                ],
                                'Migración' => [
                                    'formato_i130' => 'Petición familiar (I-130)',
                                    'formato_i485' => 'Ajuste de estatus (I-485)',
                                    'formato_i765' => 'Permiso de trabajo (I-765)',
                                    'visa_turista' => 'Visa de turista',
                                    'visa_trabajo' => 'Visa de trabajo',
                                ],
                                'Otros' => [
                                    'comprobante_domicilio' => 'Comprobante de domicilio',
                                    'antecedentes_penales' => 'Carta de antecedentes penales',
                                    'carta_empleador' => 'Carta del empleador',
                                    'otro' => 'Otro documento',
                                ],
                            ]),

                        //Textarea::make('notes')->label('Notas')->rows(2)->maxLength(255),
                    ]),

                Section::make('Archivo')
                    ->schema([
                        FileUpload::make('document_path')
                            ->label('Archivo')
                            ->required()
                            ->disk('public')
                            ->directory('client-documents')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'image/jpeg',
                                'image/png'
                            ])
                            ->openable()
                            ->downloadable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn ($record) => asset('storage/' . $record->document_path))
            ->openRecordUrlInNewTab()
            ->columns([
                TextColumn::make('document_name')
                    ->label('Documento')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(
                        fn (string $state): string =>
                        str($state)->replace('_', ' ')->title()
                    ),

                TextColumn::make('created_at')
                    ->label('Subido el')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('notes')
                    ->label('Notas')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Subir Documento')
                    ->modalWidth('6xl'),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth('6xl'),
                DeleteAction::make(),
            ])
            ->recordActionsPosition(RecordActionsPosition::AfterColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
