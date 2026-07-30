<?php

namespace App\Filament\Pages;

use App\Models\SchemaSetting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ContactPageSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?string $navigationLabel = 'Contactpagina';

    protected static ?string $title = 'Contactpagina-instellingen';

    protected string $view = 'filament.pages.contact-page-settings';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SchemaSetting::get('contact_page', []));
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Header')
                    ->description('Leeg laten valt terug op de standaardtekst.')
                    ->components([
                        FileUpload::make('image')
                            ->label('Foto')
                            ->disk('public')
                            ->directory('contact-page')
                            ->image()
                            ->columnSpanFull(),
                        TextInput::make('kicker')
                            ->label('Kicker (klein kopje boven de titel)')
                            ->placeholder('Nice2Have'),
                        TextInput::make('title')
                            ->label('Titel')
                            ->placeholder('Contact'),
                        Textarea::make('subtitle')
                            ->label('Subtekst')
                            ->placeholder('Vragen over een product of nieuwe collectie? We horen graag van je.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        SchemaSetting::set('contact_page', $this->form->getState());

        Notification::make()
            ->title('Contactpagina-instellingen opgeslagen')
            ->success()
            ->send();
    }
}
