<?php

namespace App\Filament\Resources\Procedures;

use App\Filament\Resources\Procedures\RelationManagers\PaymentsRelationManager;
use App\Filament\Resources\Procedures\Pages\CreateProcedure;
use App\Filament\Resources\Procedures\Pages\EditProcedure;
use App\Filament\Resources\Procedures\Pages\ListProcedures;
use App\Filament\Resources\Procedures\Schemas\ProcedureForm;
use App\Filament\Resources\Procedures\Tables\ProceduresTable;
use App\Models\Procedure;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use App\Filament\Resources\Procedures\RelationManagers\DocumentsRelationManager;


class ProcedureResource extends Resource
{
    protected static ?string $model = Procedure::class;

    protected static string | UnitEnum | null $navigationGroup = 'Clientes';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolderPlus;

    protected static ?string $modelLabel = 'Tramite';

    protected static ?string $pluralModelLabel = 'Tramites';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'clientCase.case_name'];
    }

    public static function form(Schema $schema): Schema
    {
        return ProcedureForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProceduresTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PaymentsRelationManager::class,
            DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProcedures::route('/'),
            'create' => CreateProcedure::route('/create'),
            'edit' => EditProcedure::route('/{record}/edit'),
        ];
    }
}
