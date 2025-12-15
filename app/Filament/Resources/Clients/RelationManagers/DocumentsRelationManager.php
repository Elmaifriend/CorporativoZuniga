<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';
    protected static ?string $recordTitleAttribute = 'document_name';

    // FORMULARIO
    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2) // 2 columnas para mejor diseño
            ->components([
                TextInput::make('document_name')
                    ->label('Nombre del Documento')
                    ->required()
                    ->placeholder('Ej. Acta Constitutiva'),

                FileUpload::make('document_path')
                    ->label('Archivo PDF')
                    ->required()
                    ->columnSpanFull()
                    ->disk('public') // Ajusta según tu configuración de discos
                    ->directory('documents')
                    ->acceptedFileTypes(['application/pdf']),

                Textarea::make('notes')
                    ->label('Notas')
                    ->rows(3)
                    ->columnSpanFull()
                    ->placeholder('Notas opcionales sobre el documento'),
            ]);
    }

    // TABLA
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('document_name')
            ->columns([
                TextColumn::make('document_name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('document_type')
                    ->label('Tipo')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('document_path')
                    ->label('Archivo')
                    ->formatStateUsing(fn ($state) => basename($state))
                    ->url(fn ($record) => asset('storage/' . $record->document_path))
                    ->openUrlInNewTab(),

                
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                //DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
