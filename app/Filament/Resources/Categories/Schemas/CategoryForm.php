<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('parent_id')
                    ->relationship('parent', 'name'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('icon'),
                RichEditor::make('description')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'h2', 'h3', 'bulletList', 'orderedList',
                        'link', 'blockquote', 'undo', 'redo',
                    ])
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('photo')
                    ->label('Foto (categorietegel)')
                    ->collection('photo')
                    ->image()
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('feature_photo')
                    ->label('Foto ("Waarom Nice2Have" sectie)')
                    ->collection('feature_photo')
                    ->image()
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('gift_photo')
                    ->label('Foto ("Cadeautip" sectie)')
                    ->collection('gift_photo')
                    ->image()
                    ->columnSpanFull(),
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
