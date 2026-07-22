<?php

namespace App\Filament\Resources\UspBlocks;

use App\Filament\Resources\UspBlocks\Pages\CreateUspBlock;
use App\Filament\Resources\UspBlocks\Pages\EditUspBlock;
use App\Filament\Resources\UspBlocks\Pages\ListUspBlocks;
use App\Filament\Resources\UspBlocks\Schemas\UspBlockForm;
use App\Filament\Resources\UspBlocks\Tables\UspBlocksTable;
use App\Models\UspBlock;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UspBlockResource extends Resource
{
    protected static ?string $model = UspBlock::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return UspBlockForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UspBlocksTable::configure($table);
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
            'index' => ListUspBlocks::route('/'),
            'create' => CreateUspBlock::route('/create'),
            'edit' => EditUspBlock::route('/{record}/edit'),
        ];
    }
}
