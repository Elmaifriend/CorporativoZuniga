<?php

namespace App\Filament\Resources\ClientCases;

use App\Filament\Resources\ClientCases\Pages\CreateClientCase;
use App\Filament\Resources\ClientCases\Pages\EditClientCase;
use App\Filament\Resources\ClientCases\Pages\ListClientCases;
use App\Filament\Resources\ClientCases\Pages\ViewClientCase;
use App\Filament\Resources\ClientCases\RelationManagers\CommentsRelationManager;
use App\Filament\Resources\ClientCases\RelationManagers\ProceduresRelationManager;
use App\Filament\Resources\ClientCases\Schemas\ClientCaseForm;
use App\Filament\Resources\ClientCases\Schemas\ClientCaseInfolist;
use App\Filament\Resources\ClientCases\Tables\ClientCasesTable;
use App\Filament\Resources\ClientCases\RelationManagers\PaymentsRelationManager;
use App\Models\ClientCase;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ClientCaseResource extends Resource
{
    protected static string | UnitEnum | null $navigationGroup = 'Clientes';

    protected static ?string $modelLabel = 'Caso';

    protected static ?string $pluralModelLabel = 'Casos';

    protected static ?string $model = ClientCase::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Cases';

    public static function form(Schema $schema): Schema
    {
        return ClientCaseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClientCaseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientCasesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ProceduresRelationManager::class,
            PaymentsRelationManager::class,
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClientCases::route('/'),
            'create' => CreateClientCase::route('/create'),
            //'view' => ViewClientCase::route('/{record}'),
            'edit' => EditClientCase::route('/{record}/edit'),
        ];
    }
}
