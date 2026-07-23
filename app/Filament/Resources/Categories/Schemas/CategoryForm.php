<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
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
                Section::make('Waarom Nice2Have')
                    ->description('Leeg laten valt terug op de standaardtekst die voor alle categorieën geldt.')
                    ->components([
                        SpatieMediaLibraryFileUpload::make('feature_photo')
                            ->label('Foto')
                            ->collection('feature_photo')
                            ->image()
                            ->columnSpanFull(),
                        TextInput::make('why_title')
                            ->label('Titel')
                            ->placeholder('Elke week nieuwe binnenkomers'),
                        Textarea::make('why_text')
                            ->label('Tekst')
                            ->placeholder('Wij volgen de trends op de voet en kopen daarom vaak en klein in. Zo is er altijd wel iets nieuws te ontdekken als je bij ons langskomt.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Cadeautip')
                    ->description('Leeg laten valt terug op de standaardtekst die voor alle categorieën geldt.')
                    ->components([
                        SpatieMediaLibraryFileUpload::make('gift_photo')
                            ->label('Foto')
                            ->collection('gift_photo')
                            ->image()
                            ->columnSpanFull(),
                        TextInput::make('gift_title')
                            ->label('Titel')
                            ->placeholder('Twijfel je nog? Een cadeaubon is altijd goed.'),
                        Textarea::make('gift_text')
                            ->label('Tekst')
                            ->placeholder('Weet je niet zeker wat iemand mooi vindt? Bij Nice2Have haal je in de winkel een cadeaubon, in te vullen naar eigen wens.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
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
