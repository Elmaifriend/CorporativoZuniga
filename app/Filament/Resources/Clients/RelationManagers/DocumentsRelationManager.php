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
use Filament\Forms\Components\Select;

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
                Select::make('document_name')
                    ->label('Tipo de documento')
                    ->columnSpanFull()
                    ->required()
                    ->placeholder('Selecciona un tipo de documento')
                    ->options([
                        // Documentos personales
                        'acta_nacimiento' => 'Acta de nacimiento',
                        'pasaporte' => 'Pasaporte',
                        'curp' => 'CURP',
                        'identificacion_oficial' => 'Identificación oficial',
                        'comprobante_domicilio' => 'Comprobante de domicilio',
                        'acta_matrimonio' => 'Acta de matrimonio',
                        'acta_divorcio' => 'Acta de divorcio',
                        'acta_defuncion' => 'Acta de defunción',

                        // Migración y USCIS / INM
                        'formato_i130' => 'Petición familiar (I-130)',
                        'formato_i485' => 'Ajuste de estatus (I-485)',
                        'formato_i601' => 'Perdón migratorio (I-601)',
                        'formato_i601a' => 'Perdón provisional (I-601A)',
                        'formato_i765' => 'Permiso de trabajo (I-765)',
                        'formato_i131' => 'Permiso de viaje (I-131)',
                        'formato_i864' => 'Declaración de patrocinio (I-864)',
                        'formato_i589' => 'Solicitud de asilo (I-589)',
                        'formato_i90' => 'Renovación de residencia (I-90)',
                        'formato_n400' => 'Naturalización (N-400)',
                        'formato_n600' => 'Certificado de ciudadanía (N-600)',

                        // Visas
                        'visa_turista' => 'Visa de turista',
                        'visa_estudiante' => 'Visa de estudiante',
                        'visa_trabajo' => 'Visa de trabajo',
                        'visa_prometido' => 'Visa de prometido/a (K-1)',
                        'visa_inversionista' => 'Visa de inversionista',
                        'visa_humanitaria' => 'Visa humanitaria',

                        // Soporte legal
                        'carta_explicativa' => 'Carta explicativa',
                        'carta_empleador' => 'Carta del empleador',
                        'antecedentes_penales' => 'Carta de antecedentes penales',
                        'pruebas_relacion' => 'Pruebas de relación familiar',
                        'pruebas_residencia' => 'Pruebas de residencia',
                        'traduccion_certificada' => 'Traducción certificada',
                        'poder_notarial' => 'Poder notarial',
                        'resolucion_migratoria' => 'Resolución migratoria',
                        'notificacion_uscis' => 'Notificación de USCIS',

                        // Última opción
                        'otro' => 'Otro',
                    ])
                    ->searchable(),

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
