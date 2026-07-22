<?php

namespace App\Filament\Resources\ContactSubmissions\Tables;

use App\Models\Store;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Ontvangen')
                    ->dateTime('d-m-Y H:i')
                    ->sortable(),
                TextColumn::make('store.name')
                    ->label('Winkel')
                    ->searchable(),
                TextColumn::make('first_name')
                    ->label('Naam')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Telefoon')
                    ->searchable(),
                TextColumn::make('subject')
                    ->label('Onderwerp')
                    ->searchable(),
                TextColumn::make('message')
                    ->label('Bericht')
                    ->limit(60)
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('store_id')
                    ->label('Winkel')
                    ->options(fn () => Store::query()->pluck('name', 'id')),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
