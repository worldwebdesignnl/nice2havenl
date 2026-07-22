<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                SpatieMediaLibraryFileUpload::make('logo')
                    ->collection('logo')
                    ->image()
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                RichEditor::make('description')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'h2', 'h3', 'bulletList', 'orderedList',
                        'link', 'blockquote', 'undo', 'redo',
                    ])
                    ->columnSpanFull(),
                TextInput::make('website_url')
                    ->url(),
                TextInput::make('meta_title'),
                TextInput::make('meta_description'),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
