<?php

namespace App\Filament\Resources\SchemaSettings\Pages;

use App\Filament\Resources\SchemaSettings\SchemaSettingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSchemaSetting extends EditRecord
{
    protected static string $resource = SchemaSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
