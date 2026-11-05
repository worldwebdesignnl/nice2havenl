<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('name')
                    ->label('Categorie')
                    ->weight('bold')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('parent.name')
                    ->label('Hoofdcategorie')
                    ->placeholder('— (hoofdcategorie)')
                    ->searchable()
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query->orderBy(
                        Category::query()
                            ->from('categories as parents')
                            ->select('parents.name')
                            ->whereColumn('parents.id', 'categories.parent_id')
                            ->limit(1),
                        $direction,
                    )),
                TextColumn::make('products_count')
                    ->label('Producten')
                    ->counts('products')
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('icon')
                    ->searchable(),
                TextColumn::make('meta_title')
                    ->searchable(),
                TextColumn::make('meta_description')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->label('Volgorde')
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
                SelectFilter::make('parent_id')
                    ->label('Hoofdcategorie')
                    ->relationship('parent', 'name')
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
