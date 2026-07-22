<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->required()
                    ->searchable(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Select::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload()
                    ->required(),
                Textarea::make('short_description')
                    ->columnSpanFull(),
                RichEditor::make('description')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'h2', 'h3', 'bulletList', 'orderedList',
                        'link', 'blockquote', 'undo', 'redo',
                    ])
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('€'),
                TextInput::make('price_label')
                    ->placeholder('vanaf'),
                Toggle::make('is_featured')
                    ->required(),
                TextInput::make('meta_title'),
                TextInput::make('meta_description'),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                SpatieMediaLibraryFileUpload::make('gallery')
                    ->collection('gallery')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->columnSpanFull(),
            ]);
    }
}
