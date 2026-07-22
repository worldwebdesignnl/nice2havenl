<?php

namespace App\Filament\Resources\HeroSlides\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class HeroSlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                SpatieMediaLibraryFileUpload::make('image')
                    ->collection('image')
                    ->image()
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('kicker'),
                TextInput::make('title')
                    ->required(),
                Textarea::make('subtitle')
                    ->columnSpanFull(),
                TextInput::make('button_label'),
                TextInput::make('button_url'),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
