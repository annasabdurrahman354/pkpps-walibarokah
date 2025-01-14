<?php

namespace App\Filament\Pages;

use App\Settings\PengaturanSitus;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\SettingsPage;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Support\Htmlable;
use function Filament\Support\is_app_url;

class KelolaSitus extends SettingsPage
{
    use HasPageShield;
    protected static string $settings = PengaturanSitus::class;

    protected static ?int $navigationSort = 99;
    protected static ?string $navigationIcon = 'fluentui-settings-20';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $settings = app(static::getSettings());

        $data = $this->mutateFormDataBeforeFill($settings->toArray());

        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Site')
                    ->label(fn () => __('page.general_settings.sections.site'))
                    ->description(fn () => __('page.general_settings.sections.site.description'))
                    ->icon('fluentui-web-asset-24-o')
                    ->schema([
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\TextInput::make('brand_name')
                                ->label(fn () => __('page.general_settings.fields.brand_name'))
                                ->required(),
                            Forms\Components\Select::make('site_active')
                                ->label(fn () => __('page.general_settings.fields.site_active'))
                                ->options([
                                    0 => "Not Active",
                                    1 => "Active",
                                ])
                                ->native(false)
                                ->required(),
                        ]),
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\TextInput::make('brand_logoHeight')
                                ->label(fn () => __('page.general_settings.fields.brand_logoHeight'))
                                ->required()
                                ->columnSpanFull()
                                ->maxWidth('w-1/2'),
                            Forms\Components\Grid::make()->schema([
                                Forms\Components\FileUpload::make('brand_logo')
                                    ->label(fn () => __('page.general_settings.fields.brand_logo'))
                                    ->image()
                                    ->directory('sites')
                                    ->visibility('public')
                                    ->moveFiles()
                                    ->required(),

                                Forms\Components\FileUpload::make('site_favicon')
                                    ->label(fn () => __('page.general_settings.fields.site_favicon'))
                                    ->image()
                                    ->directory('sites')
                                    ->visibility('public')
                                    ->moveFiles()
                                    ->acceptedFileTypes(['image/x-icon', 'image/vnd.microsoft.icon'])
                                    ->required(),
                            ]),
                        ])->columns(4),
                    ]),
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Color Palette')
                            ->schema([
                                Forms\Components\ColorPicker::make('site_theme.primary')
                                    ->label(fn () => __('page.general_settings.fields.primary')),
                                Forms\Components\ColorPicker::make('site_theme.secondary')
                                    ->label(fn () => __('page.general_settings.fields.secondary')),
                                Forms\Components\ColorPicker::make('site_theme.gray')
                                    ->label(fn () => __('page.general_settings.fields.gray')),
                                Forms\Components\ColorPicker::make('site_theme.success')
                                    ->label(fn () => __('page.general_settings.fields.success')),
                                Forms\Components\ColorPicker::make('site_theme.danger')
                                    ->label(fn () => __('page.general_settings.fields.danger')),
                                Forms\Components\ColorPicker::make('site_theme.info')
                                    ->label(fn () => __('page.general_settings.fields.info')),
                                Forms\Components\ColorPicker::make('site_theme.warning')
                                    ->label(fn () => __('page.general_settings.fields.warning')),
                            ])
                            ->columns(3),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ])
            ->columns(3)
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->mutateFormDataBeforeSave($this->form->getState());

            $settings = app(static::getSettings());

            $settings->fill($data);
            $settings->save();

            Notification::make()
                ->title('Settings updated.')
                ->success()
                ->send();

            $this->redirect(static::getUrl(), navigate: FilamentView::hasSpaMode() && is_app_url(static::getUrl()));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Pengaturan';
    }

    public static function getNavigationLabel(): string
    {
        return __("page.general_settings.navigationLabel");
    }

    public function getTitle(): string|Htmlable
    {
        return __("page.general_settings.title");
    }

    public function getHeading(): string|Htmlable
    {
        return __("page.general_settings.heading");
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __("page.general_settings.subheading");
    }
}
