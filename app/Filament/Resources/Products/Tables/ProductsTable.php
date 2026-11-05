<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Category;
use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('brand.name')
                    ->label('Merk')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('categories.name')
                    ->label('Categorie')
                    ->badge()
                    ->placeholder('—')
                    ->searchable()
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query->orderBy(
                        Category::query()
                            ->select('categories.name')
                            ->join('category_product', 'categories.id', '=', 'category_product.category_id')
                            ->whereColumn('category_product.product_id', 'products.id')
                            ->orderBy('categories.name')
                            ->limit(1),
                        $direction,
                    )),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('price')
                    ->money('EUR')
                    ->sortable(),
                TextColumn::make('price_label')
                    ->searchable(),
                IconColumn::make('is_featured')
                    ->boolean(),
                TextColumn::make('meta_title')
                    ->searchable(),
                TextColumn::make('meta_description')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('categories')
                    ->label('Categorie')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload(),
                SelectFilter::make('brand')
                    ->label('Merk')
                    ->relationship('brand', 'name')
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
