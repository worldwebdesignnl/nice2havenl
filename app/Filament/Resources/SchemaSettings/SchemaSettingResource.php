<?php

namespace App\Filament\Resources\SchemaSettings;

use App\Filament\Resources\SchemaSettings\Pages\CreateSchemaSetting;
use App\Filament\Resources\SchemaSettings\Pages\EditSchemaSetting;
use App\Filament\Resources\SchemaSettings\Pages\ListSchemaSettings;
use App\Filament\Resources\SchemaSettings\Schemas\SchemaSettingForm;
use App\Filament\Resources\SchemaSettings\Tables\SchemaSettingsTable;
use App\Models\SchemaSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SchemaSettingResource extends Resource
{
    protected static ?string $model = SchemaSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return SchemaSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SchemaSettingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSchemaSettings::route('/'),
            'create' => CreateSchemaSetting::route('/create'),
            'edit' => EditSchemaSetting::route('/{record}/edit'),
        ];
    }
}
