<?php

namespace App\Filament\Resources\SchemaSettings\Pages;

use App\Filament\Resources\SchemaSettings\SchemaSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSchemaSettings extends ListRecords
{
    protected static string $resource = SchemaSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
