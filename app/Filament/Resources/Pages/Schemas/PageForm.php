<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                RichEditor::make('body')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'h2', 'h3', 'bulletList', 'orderedList',
                        'link', 'blockquote', 'undo', 'redo',
                    ])
                    ->columnSpanFull(),
                TextInput::make('template'),
                TextInput::make('meta_title'),
                TextInput::make('meta_description'),
                Toggle::make('is_published')
                    ->required(),
                DateTimePicker::make('published_at'),
            ]);
    }
}
