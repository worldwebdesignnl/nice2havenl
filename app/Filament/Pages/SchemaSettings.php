<?php

namespace App\Filament\Pages;

use App\Models\SchemaSetting;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SchemaSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'SEO Schema';

    protected static ?string $title = 'SEO Schema-instellingen';

    protected string $view = 'filament.pages.schema-settings';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'organization' => SchemaSetting::get('organization', []),
            'schema_org_enabled' => SchemaSetting::get('schema_org_enabled', true),
            'schema_local_enabled' => SchemaSetting::get('schema_local_enabled', true),
            'schema_breadcrumb_enabled' => SchemaSetting::get('schema_breadcrumb_enabled', true),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Inschakelen')
                    ->description('Bepaal welke schema.org-blokken automatisch op de website worden gepubliceerd.')
                    ->components([
                        Toggle::make('schema_org_enabled')
                            ->label('Organisatie schema'),
                        Toggle::make('schema_local_enabled')
                            ->label('Winkel (LocalBusiness) schema'),
                        Toggle::make('schema_breadcrumb_enabled')
                            ->label('Breadcrumb schema'),
                    ])
                    ->columns(2),

                Section::make('Organisatie')
                    ->description('Deze gegevens worden gebruikt voor het Organization-schema op de homepage.')
                    ->components([
                        TextInput::make('organization.name')
                            ->label('Bedrijfsnaam')
                            ->placeholder(config('app.name')),
                        TextInput::make('organization.logo')
                            ->label('Logo URL')
                            ->placeholder('/images/logo.png')
                            ->helperText('Absolute URL of pad dat begint met /, bijvoorbeeld /images/logo.png'),
                        TextInput::make('organization.email')
                            ->label('E-mailadres')
                            ->email(),
                        TextInput::make('organization.phone')
                            ->label('Telefoonnummer')
                            ->tel(),
                        TextInput::make('organization.instagram_url')
                            ->label('Instagram URL')
                            ->url(),
                        TextInput::make('organization.facebook_url')
                            ->label('Facebook URL')
                            ->url(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SchemaSetting::set('organization', $data['organization'] ?? []);
        SchemaSetting::set('schema_org_enabled', (bool) ($data['schema_org_enabled'] ?? true));
        SchemaSetting::set('schema_local_enabled', (bool) ($data['schema_local_enabled'] ?? true));
        SchemaSetting::set('schema_breadcrumb_enabled', (bool) ($data['schema_breadcrumb_enabled'] ?? true));

        Notification::make()
            ->title('Schema-instellingen opgeslagen')
            ->success()
            ->send();
    }
}
