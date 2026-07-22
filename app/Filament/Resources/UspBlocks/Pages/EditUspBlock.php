<?php

namespace App\Filament\Resources\UspBlocks\Pages;

use App\Filament\Resources\UspBlocks\UspBlockResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUspBlock extends EditRecord
{
    protected static string $resource = UspBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
