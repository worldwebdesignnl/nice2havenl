<?php

namespace App\Filament\Resources\Stores\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class StoreForm
{
    private const DAYS = [
        0 => 'Maandag', 1 => 'Dinsdag', 2 => 'Woensdag', 3 => 'Donderdag',
        4 => 'Vrijdag', 5 => 'Zaterdag', 6 => 'Zondag',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('address_line')
                    ->required(),
                TextInput::make('postal_code')
                    ->required(),
                TextInput::make('city')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('shopping_center'),
                RichEditor::make('description')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'h2', 'h3', 'bulletList', 'orderedList',
                        'link', 'blockquote', 'undo', 'redo',
                    ])
                    ->columnSpanFull(),
                TextInput::make('latitude')
                    ->numeric(),
                TextInput::make('longitude')
                    ->numeric(),
                TextInput::make('google_maps_url')
                    ->url(),
                TextInput::make('meta_title'),
                TextInput::make('meta_description'),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                SpatieMediaLibraryFileUpload::make('photo')
                    ->label('Foto (winkelpagina)')
                    ->collection('photo')
                    ->image()
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('area_photo')
                    ->label('Foto ("Winkelen in de buurt" sectie)')
                    ->collection('area_photo')
                    ->image()
                    ->columnSpanFull(),
                Repeater::make('openingHours')
                    ->relationship('openingHours')
                    ->label('Openingstijden')
                    ->schema([
                        Select::make('day_of_week')
                            ->options(self::DAYS)
                            ->required(),
                        TimePicker::make('opens_at'),
                        TimePicker::make('closes_at'),
                        Toggle::make('is_closed')
                            ->label('Gesloten'),
                    ])
                    ->columns(4)
                    ->columnSpanFull(),
            ]);
    }
}
