<?php

namespace App\Filament\Resources\UspBlocks\Pages;

use App\Filament\Resources\UspBlocks\UspBlockResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUspBlocks extends ListRecords
{
    protected static string $resource = UspBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
