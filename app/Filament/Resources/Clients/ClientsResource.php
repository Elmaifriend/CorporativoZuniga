<?php

namespace App\Filament\Resources\Clients;

use App\Filament\Resources\Clients\Pages\CreateClients;
use App\Filament\Resources\Clients\Pages\EditClients;
use App\Filament\Resources\Clients\Pages\ListClients;
use App\Filament\Resources\Clients\Pages\ViewClients;
use App\Filament\Resources\Clients\RelationManagers\AppointmentsRelationManager;
use App\Filament\Resources\Clients\RelationManagers\CasesRelationManager;
use App\Filament\Resources\Clients\RelationManagers\DocumentsRelationManager;
use App\Filament\Resources\Clients\RelationManagers\ClientPaymentsRelationManager;
use App\Filament\Resources\Clients\RelationManagers\RecurrentPaymentsRelationManager;
use App\Filament\Resources\Clients\Schemas\ClientsForm;
use App\Filament\Resources\Clients\Schemas\ClientsInfolist;
use App\Filament\Resources\Clients\Tables\ClientsTable;
use App\Models\Appointments;
use App\Models\Client;
use App\Models\RecurrentPayment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ClientsResource extends Resource
{   
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string | UnitEnum | null $navigationGroup = 'Clientes';

    protected static ?string $modelLabel = 'Cliente';

    protected static ?string $pluralModelLabel = 'Clientes';

    protected static ?string $model = Client::class;

    public static function form(Schema $schema): Schema
    {
        return ClientsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClientsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CasesRelationManager::class,
            DocumentsRelationManager::class,
            AppointmentsRelationManager::class,
            ClientPaymentsRelationManager::class,
            RecurrentPaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClients::route('/'),
            'create' => CreateClients::route('/create'),
            //'view' => ViewClients::route('/{record}'),
            'edit' => EditClients::route('/{record}/edit'),
        ];
    }
}
