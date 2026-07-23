<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use Filament\Actions\DeleteAction;
use Filament\Actions\ReplicateAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ReplicateAction::make()
                ->label('Dupliceren')
                ->beforeReplicaSaved(function (Product $replica) {
                    $replica->name = $replica->name.' (kopie)';
                    $replica->slug = null;
                    $replica->is_active = false;
                })
                ->after(function (Product $record, Product $replica) {
                    $replica->categories()->sync($record->categories->pluck('id'));
                }),
            DeleteAction::make(),
        ];
    }
}
