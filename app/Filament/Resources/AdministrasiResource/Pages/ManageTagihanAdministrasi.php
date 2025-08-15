<?php

namespace App\Filament\Resources\AdministrasiResource\Pages;

use App\Enums\StatusTagihan;
use App\Filament\Resources\AdministrasiResource;
use App\Models\Siswa;
use App\Models\TagihanAdministrasi;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class ManageTagihanAdministrasi extends ManageRelatedRecords
{
    protected static string $resource = AdministrasiResource::class;

    protected static string $relationship = 'tagihanAdministrasi';

    protected static ?string $navigationIcon = 'fluentui-people-list-24';
    public function getTitle(): string | Htmlable
    {
        $recordTitle = $this->getRecordTitle();

        $recordTitle = $recordTitle instanceof Htmlable ? $recordTitle->toHtml() : $recordTitle;

        return "Kelola Tagihan {$recordTitle}";
    }

    public function getBreadcrumb(): string
    {
        return 'Kelola Tagihan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Kelola Tagihan';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('siswa_id')
                    ->hiddenLabel()
                    ->placeholder('Pilih siswa untuk ditagih...')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->getSearchResultsUsing(fn (string $search, Get $get, ManageRelatedRecords $livewire): array =>
                        Siswa::where('nama', 'like', "%{$search}%")
                            ->whereKelasSekolahIn($get('../../sasaran'))
                            ->whereDitagih()
                            ->whereDoesntHave('tagihanAdministrasi', function ($query) use ($livewire) {
                                $query->where('administrasi_id', $livewire->getOwnerRecord()->id);
                            })
                            ->limit(20)
                            ->pluck('nama', 'id')
                            ->toArray(),
                    )
                    ->getOptionLabelUsing(fn ($value): ?string => Siswa::find($value)?->nama)
                    ->columnSpan(3)
                    ->afterStateUpdated(function (Get $get, Set $set, ManageRelatedRecords $livewire, $state) {
                        $siswa = Siswa::where('id', $state)->first();
                        $nominal_tagihan = current(array_filter($livewire->getOwnerRecord()->nominal_tagihan, fn($item) => $item['kategori_administrasi'] === $siswa->kategori_administrasi))['nominal_tagihan'];
                        $set('jenis_kelamin', $siswa->jenis_kelamin);
                        $set('kelas', $siswa->kelasRombel);
                        $set('nominal_tagihan', $nominal_tagihan);
                    }),

                TextInput::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('kelas')
                    ->label('Kelas')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('nominal_tagihan')
                    ->label('Nominal Tagihan')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->minValue(0)
                    ->prefix('Rp')
                    ->suffix(',00')
                    ->required(),

                Select::make('status_tagihan')
                    ->label('Status Tagihan')
                    ->options(StatusTagihan::class)
                    ->default(StatusTagihan::BELUM_BAYAR)
                    ->required(),
            ])
            ->columns(3);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                TextEntry::make('administrasi.jenisAdministrasi.nama'),
                TextEntry::make('siswa.nama'),
                TextEntry::make('siswa.kelas_sekolah'),
                TextEntry::make('siswa.rombel_kelas_sekolah'),
                TextEntry::make('nominal_tagihan')
                    ->money('IDR'),
                TextEntry::make('status_tagihan')
                    ->badge(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns(TagihanAdministrasi::getColumns())
            ->filters([
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
