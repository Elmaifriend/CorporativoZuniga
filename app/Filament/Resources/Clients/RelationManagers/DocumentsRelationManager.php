<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Documentación Digital';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Clasificación del Documento')
                    ->schema([
                        Select::make('document_name')
                            ->label('Tipo de Documento')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->prefixIcon('heroicon-m-tag')
                            ->options([
                                'Identidad' => [
                                    'acta_nacimiento' => 'Acta de nacimiento',
                                    'pasaporte' => 'Pasaporte',
                                    'curp' => 'CURP',
                                    'identificacion_oficial' => 'Identificación oficial (INE/Cédula)',
                                    'acta_matrimonio' => 'Acta de matrimonio',
                                ],
                                'Migración (USCIS / INM)' => [
                                    'formato_i130' => 'Petición familiar (I-130)',
                                    'formato_i485' => 'Ajuste de estatus (I-485)',
                                    'formato_i765' => 'Permiso de trabajo (I-765)',
                                    'visa_turista' => 'Visa de turista',
                                    'visa_trabajo' => 'Visa de trabajo',
                                ],
                                'Soporte y Otros' => [
                                    'comprobante_domicilio' => 'Comprobante de domicilio',
                                    'antecedentes_penales' => 'Carta de antecedentes penales',
                                    'carta_empleador' => 'Carta del empleador',
                                    'otro' => 'Otro documento',
                                ],
                            ]),

                        Textarea::make('notes')
                            ->label('Notas / Observaciones')
                            ->rows(2)
                            ->placeholder('Detalles adicionales sobre la vigencia o estado del documento...')
                            ->maxLength(255),
                    ]),

                Section::make('Archivo Adjunto')
                    ->schema([
                        FileUpload::make('document_path')
                            ->label('Cargar PDF')
                            ->required()
                            ->disk('public')
                            ->directory('client-documents') // Carpeta organizada
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->openable()
                            ->downloadable()
                            ->columnSpanFull(),
                    ])->collapsible(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('document_name')
            ->columns([
                TextColumn::make('document_name')
                    ->label('Documento')
                    ->searchable()
                    ->sortable()
                    ->icon(fn (string $state): string => match ($state) {
                        'pasaporte', 'visa_turista' => 'heroicon-m-globe-americas',
                        'acta_nacimiento', 'acta_matrimonio' => 'heroicon-m-user-group',
                        'curp', 'identificacion_oficial' => 'heroicon-m-identification',
                        default => 'heroicon-m-document-text',
                    })
                    ->formatStateUsing(fn (string $state): string => str($state)->replace('_', ' ')->title()),

                TextColumn::make('created_at')
                    ->label('Subido el')
                    ->date('d M Y')
                    ->sortable()
                    ->color('gray'),

                TextColumn::make('notes')
                    ->label('Notas')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Subir Documento')
                    ->slideOver()
                    ->modalWidth('md'),
            ])
            ->recordActions([
                EditAction::make()->slideOver(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
