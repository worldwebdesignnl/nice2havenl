<?php

namespace App\Filament\Resources\MenuItems\Schemas;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Store;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('location')
                    ->options(['top' => 'Topmenu', 'footer' => 'Footermenu'])
                    ->required(),
                Select::make('parent_id')
                    ->relationship('parent', 'label'),
                TextInput::make('label')
                    ->required(),
                MorphToSelect::make('linkable')
                    ->label('Link naar')
                    ->types([
                        Type::make(Category::class)->titleColumnName('name'),
                        Type::make(Brand::class)->titleColumnName('name'),
                        Type::make(Product::class)->titleColumnName('name'),
                        Type::make(Store::class)->titleColumnName('name'),
                        Type::make(Page::class)->titleColumnName('title'),
                    ]),
                TextInput::make('url')
                    ->label('Of vrije URL')
                    ->helperText('Alleen gebruiken als er niet naar een pagina/categorie/merk/winkel/product wordt gelinkt.'),
                Select::make('target')
                    ->options(['_self' => 'Zelfde tab', '_blank' => 'Nieuwe tab'])
                    ->default('_self')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
