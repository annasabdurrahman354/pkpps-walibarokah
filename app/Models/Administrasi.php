<?php

namespace App\Models;

use App\Enums\FrekuensiPenagihan;
use App\Enums\KategoriAdministrasi;
use App\Enums\KelasSekolah;
use App\Enums\PeriodeTagihan;
use App\Enums\PeriodeTagihanBulanan;
use App\Enums\PeriodeTagihanSemesteran;
use App\Enums\StatusTagihan;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Enums\Alignment;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Administrasi extends Model
{
    use HasFactory, HasUlids, SoftDeletes;
    use SoftCascadeTrait;

    protected $softCascade = ['tagihanAdministrasi'];
    protected $table = 'administrasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jenis_administrasi_id',
        'tahun_ajaran',
        'periode',
        'sasaran',
        'nominal_tagihan',
        'batas_awal_pembayaran',
        'batas_akhir_pembayaran',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $casts = [
        'sasaran' => 'array',
        'nominal_tagihan' => 'array',
        'batas_awal_pembayaran' => 'date',
        'batas_akhir_pembayaran' => 'date',
        'periode' => PeriodeTagihan::class,
    ];

    protected function recordTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->nama_administrasi.'('.$this->tahun_ajaran.'-'.$this->periode.')',
        );
    }

    public function jenisAdministrasi(): BelongsTo
    {
        return $this->belongsTo(JenisAdministrasi::class);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran', 'tahun_ajaran');
    }

    public function tagihanAdministrasi(): HasMany
    {
        return $this->hasMany(TagihanAdministrasi::class, 'administrasi_id');
    }

    public function pembayaranAdministrasi(): HasManyThrough
    {
        return $this->hasManyThrough(
            PembayaranAdministrasi::class, // Final model to reach
            TagihanAdministrasi::class,   // Intermediate model
            'administrasi_id',            // Foreign key on TagihanAdministrasi
            'tagihan_administrasi_id',    // Foreign key on PembayaranAdministrasi
            'id',                         // Local key on Administrasi
            'id'                          // Local key on TagihanAdministrasi
        );
    }

    public function tagihanLunas()
    {
        return $this->tagihanAdministrasi()->where('status_tagihan', StatusTagihan::LUNAS->value)->get();
    }

    public function tagihanBelumLunas()
    {
        return $this->tagihanAdministrasi()->whereNot('status_tagihan', StatusTagihan::LUNAS->value)->get();
    }

    public function countTagihanLunas(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tagihanAdministrasi()->where('status_tagihan', StatusTagihan::LUNAS->value)->count(),
        );
    }

    public function countTagihanBelumLunas(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tagihanAdministrasi()->whereNot('status_tagihan', StatusTagihan::LUNAS->value)->count(),
        );
    }

    public function sumJumlahPembayaran(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->pembayaranAdministrasi()->sum('jumlah_pembayaran'),
        );
    }

    protected static function booted(): void
    {
        parent::boot();
        static::created(function (Administrasi $record) {
            TahunAjaran::firstOrCreate(
                ['tahun_ajaran' =>  $record->tahun_ajaran],
            );
        });
    }

    public static function getBulkForm()
    {
        return [
            Section::make('Detail Pembayaran ')->columns(2)->schema([
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

                CheckboxList::make('periode_tagihan')
                    ->label('Periode Tagihan')
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
                    ->columns(2)
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
                ->hiddenOn('edit')
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
                                        'status_tagihan' => StatusTagihan::BELUM_BAYAR->value
                                    ];
                                });

                                $set('tagihanSiswa', $tagihanData->toArray());
                            })
                ])->alignment(Alignment::Center),
            ]),

            Section::make('Tagihan Siswa')->schema([
                TableRepeater::make('tagihanSiswa')
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
                            ->content(fn(Get $get) => Siswa::where('id', $get('siswa_id'))->first()?->jenis_kelamin->getLabel()),

                        Placeholder::make('kelas')
                            ->hiddenLabel()
                            ->content(fn(Get $get) => Siswa::where('id', $get('siswa_id'))->first()?->kelasRombel),

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
                            ->options(StatusTagihan::class)
                            ->default(StatusTagihan::BELUM_BAYAR)
                            ->required(),
                    ])
                    ->addActionLabel('+ Tagihan Siswa'),
            ]),
        ];
    }
}
