<?php

namespace App\Filament\Resources;

use App\Enums\FrekuensiPenagihan;
use App\Enums\KategoriAdministrasi;
use App\Enums\KelasSekolah;
use App\Enums\PeriodeTagihanBulanan;
use App\Enums\PeriodeTagihanSemesteran;
use App\Enums\StatusTagihan;
use App\Filament\Resources\AdministrasiResource\Pages\CreateAdministrasi;
use App\Filament\Resources\AdministrasiResource\Pages\EditAdministrasi;
use App\Filament\Resources\AdministrasiResource\Pages\ListAdministrasis;
use App\Filament\Resources\AdministrasiResource\Pages\ManageTagihanAdministrasi;
use App\Filament\Resources\AdministrasiResource\Pages\ViewAdministrasi;
use App\Models\Administrasi;
use App\Models\JenisAdministrasi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdministrasiResource extends Resource
{
    protected static ?string $model = Administrasi::class;
    protected static ?string $slug = 'data-administrasi';
    protected static ?string $modelLabel = 'Administrasi';
    protected static ?string $pluralModelLabel = 'Administrasi';
    protected static ?string $recordTitleAttribute = 'recordTitle';

    protected static ?string $navigationLabel = 'Administrasi';
    protected static ?string $navigationGroup = 'Administrasi';
    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?int $navigationSort = 41;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Administrasi ')->columns(2)->schema([
                    Select::make('tahun_ajaran')
                        ->label('Tahun Ajaran')
                        ->relationship('tahunAjaran', 'tahun_ajaran')
                        ->searchable()
                        ->preload()
                        ->default(fn() => str(date('Y')).'/'.str(date('Y')+1))
                        ->createOptionForm(TahunAjaran::getForm())
                        ->createOptionUsing(function (array $data) {
                            return TahunAjaran::create($data)->getKey();
                        })
                        ->required(),

                    Select::make('jenis_administrasi_id')
                        ->label('Jenis Administrasi')
                        ->relationship('jenisAdministrasi', 'nama')
                        ->searchable()
                        ->preload()
                        ->createOptionForm(JenisAdministrasi::getForm())
                        ->createOptionUsing(function (array $data) {
                            return JenisAdministrasi::create($data)->getKey();
                        })
                        ->required()
                        ->afterStateUpdated(fn ($state, Get $get, Set $set) => match (JenisAdministrasi::where('id', $state)->first()?->frekuensi_penagihan->value) {
                            FrekuensiPenagihan::BULANAN->value => $set('periode', []),
                            FrekuensiPenagihan::SEMESTERAN->value => $set('periode', []),
                            FrekuensiPenagihan::TAHUNAN->value => $set('periode', $get('tahun_ajaran')),
                            default => $set('periode', $get('tahun_ajaran').'('.\Carbon\Carbon::now()->locale('id')->translatedFormat('F').')')
                        })
                        ->live(),

                    ToggleButtons::make('periode')
                        ->label('Periode')
                        ->options(fn (Get $get) => match (JenisAdministrasi::where('id', $get('jenis_administrasi_id'))->first()?->frekuensi_penagihan->value) {
                            FrekuensiPenagihan::BULANAN->value => PeriodeTagihanBulanan::class,
                            FrekuensiPenagihan::SEMESTERAN->value => PeriodeTagihanSemesteran::class,
                            FrekuensiPenagihan::TAHUNAN->value => [$get('tahun_ajaran') => $get('tahun_ajaran')],
                            default => [$get('tahun_ajaran').'('.\Carbon\Carbon::now()->locale('id')->translatedFormat('F').')' => $get('tahun_ajaran').' ('.\Carbon\Carbon::now()->locale('id')->translatedFormat('F').')']
                        })
                        ->default(fn (Get $get) => match (JenisAdministrasi::where('id', $get('jenis_administrasi_id'))->first()?->frekuensi_penagihan->value) {
                            FrekuensiPenagihan::BULANAN->value => '',
                            FrekuensiPenagihan::SEMESTERAN->value => '',
                            FrekuensiPenagihan::TAHUNAN->value => $get('tahun_ajaran'),
                            default => $get('tahun_ajaran').'('.\Carbon\Carbon::now()->locale('id')->translatedFormat('F').')'
                        })
                        ->inline()
                        //->visible(fn(Get $get) => in_array(JenisAdministrasi::where('id', $get('jenis_administrasi_id'))->first()?->frekuensi_penagihan->value, [FrekuensiPenagihan::BULANAN->value, FrekuensiPenagihan::SEMESTERAN->value]) )
                        ->columnSpanFull(),

                    TableRepeater::make('nominal_tagihan')
                        ->label('Nominal Tagihan')
                        ->headers([
                            Header::make('Kategori Administrasi'),
                            Header::make('Tagihan')
                        ])
                        ->schema([
                            Select::make('kategori_administrasi')
                                ->options(KategoriAdministrasi::class)
                                ->disabled()
                                ->dehydrated(),
                            TextInput::make('nominal_tagihan')
                                ->mask(RawJs::make('$money($input)'))
                                ->stripCharacters(',')
                                ->numeric()
                                ->minValue(0)
                                ->prefix('Rp')
                                ->suffix(',00')
                                ->required(),
                        ])
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->default(fn() => array_map(function($item) {
                            return [
                                'kategori_administrasi' => $item,
                                'nominal_tagihan' => 0
                            ];
                        }, array_column(KategoriAdministrasi::cases(), 'value')))
                        ->columnSpanFull()
                ]),

                Section::make('Sasaran')
                    ->columns(1)
                    ->schema([
                        Select::make('sasaran')
                            ->label('Pilih Kelas Sasaran')
                            ->multiple()
                            ->disabledOn('edit')
                            ->options(KelasSekolah::class)
                            ->required()
                            ->live(),
                        Actions::make([
                            Action::make('tampilkanTagihanSantri')
                                ->label('Tampilkan Tagihan')
                                ->color('info')
                                ->icon('heroicon-m-user')
                                ->disabled(fn (string $operation) => $operation != 'create')
                                ->visible(fn(Get $get) => !empty($get('sasaran')))
                                ->requiresConfirmation()
                                ->action(function (Get $get, Set $set, $state) {
                                    $siswa = Siswa::whereKelasSekolahIn($get('sasaran'))
                                        ->whereDitagih()
                                        ->orderBy('kelas_sekolah')
                                        ->orderBy('jenis_kelamin')
                                        ->orderBy('rombel_kelas_sekolah')
                                        ->orderBy('nama')
                                        ->get();

                                    $tagihanData = $siswa->map(function ($siswa) use ($get, $state) {
                                        return [
                                            'user_id' => $siswa->id,
                                            'jenis_kelamin' => $siswa->jenis_kelamin,
                                            'kelas' => $siswa->kelasRombel,
                                            'nominal_tagihan' => current(array_filter($state['nominal_tagihan'], fn($item) => $item['kategori_administrasi'] === $siswa->kategori_administrasi))['nominal_tagihan'],
                                            'status_tagihan' => StatusTagihan::BELUM_BAYAR,
                                        ];
                                    });

                                    $set('tagihanAdministrasi', $tagihanData->toArray());
                                })
                    ])->alignment(Alignment::Center),
                ]),

                Section::make('Tagihan Administrasi')->schema([
                    TableRepeater::make('tagihanAdministrasi')
                        ->relationship('tagihanAdministrasi')
                        ->default([])
                        ->headers([
                            Header::make('Siswa'),
                            Header::make('Jenis Kelamin'),
                            Header::make('Kelas'),
                            Header::make('Nominal Tagihan'),
                            Header::make('Status Tagihan'),
                        ])
                        ->schema([
                            Select::make('siswa_id')
                                ->hiddenLabel()
                                ->placeholder('Pilih siswa untuk ditagih...')
                                ->required()
                                ->distinct()
                                ->searchable()
                                ->preload()
                                ->getSearchResultsUsing(fn (string $search, Get $get): array =>
                                    Siswa::where('nama', 'like', "%{$search}%")
                                        ->whereKelasSekolahIn($get('../../sasaran'))
                                        ->whereDitagih()
                                        ->limit(20)
                                        ->pluck('nama', 'id')
                                        ->toArray()
                                )
                                ->getOptionLabelUsing(fn ($value): ?string => Siswa::find($value)?->nama)
                                ->columnSpan(4)
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems(),

                            Placeholder::make('jenis_kelamin')
                                ->hiddenLabel()
                                ->content(fn(Get $get) => Siswa::where('id', $get('user_id'))->first()?->jenis_kelamin->getLabel()),

                            Placeholder::make('kelas')
                                ->hiddenLabel()
                                ->content(fn(Get $get) => Siswa::where('id', $get('siswa_id'))->first()?->kelasRombel),

                            TextInput::make('nominal_tagihan')
                                ->hiddenLabel()
                                ->mask(RawJs::make('$money($input)'))
                                ->stripCharacters(',')
                                ->numeric()
                                ->minValue(0)
                                ->prefix('Rp')
                                ->suffix(',00')
                                ->required(),

                            Select::make('status_tagihan')
                                ->hiddenLabel()
                                ->options(StatusTagihan::class)
                                ->required(),
                        ])
                        ->addActionLabel('+ Tagihan Administrasi'),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenisAdministrasi.nama')
                    ->label('Nama Administrasi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenisAdministrasi.frekuensi_penagihan')
                    ->label('Frekuensi Penagihan')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('periode')
                    ->label('Periode')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sasaran')
                    ->label('Sasaran')
                    ->badge()
                    ->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('nominal_tagihan')
                    ->label('Nominal Tagihan')
                    ->state(fn($record) => array_map(function ($item) {
                        return "{$item['kategori_administrasi']} : Rp. " . number_format($item['nominal_tagihan'], 0, ',', '.');
                    }, $record->nominal_tagihan))
                    ->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('batas_awal_pembayaran')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('batas_akhir_pembayaran')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenisAdministrasi.rekening.nomor_rekening')
                    ->label('Nomor Rekening Pembayaran')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenisAdministrasi.rekening.nama_bank')
                    ->label('Nama Bank')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenisAdministrasi.rekening.nama_pemilik')
                    ->label('Nama Pemilik')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('rekening.kepemilikan_rekening')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                    //Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->selectCurrentPageOnly();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewAdministrasi::class,
            ManageTagihanAdministrasi::class,
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdministrasis::route('/'),
            'create' => CreateAdministrasi::route('/create'),
            'view' => ViewAdministrasi::route('/{record}'),
            'edit' => EditAdministrasi::route('/{record}/edit'),
            'tagihan-administrasi' => ManageTagihanAdministrasi::route('/{record}/tagihan-administrasi'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
