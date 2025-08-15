<?php

namespace App\Models;

use App\Enums\KategoriAdministrasi;
use App\Enums\MetodePembayaran;
use App\Enums\StatusTagihan;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Filament\Support\RawJs;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagihanAdministrasi extends Model
{
    use HasFactory, HasUlids, SoftDeletes;
    use SoftCascadeTrait;

    protected $softCascade = ['pembayaranAdministrasi'];
    protected $table = 'tagihan_administrasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'administrasi_id',
        'siswa_id',
        'nominal_tagihan',
        'status_tagihan'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $casts = [
        'nominal_tagihan' => 'integer',
        'status_tagihan' => StatusTagihan::class,
    ];

    protected function recordTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Tagihan '.$this->siswa->nama.' '.$this->administrasi->recordTitle,
        );
    }

    public function administrasi(): BelongsTo
    {
        return $this->belongsTo(Administrasi::class, 'administrasi_id');
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function pembayaranAdministrasi(): HasMany
    {
        return $this->hasMany(PembayaranAdministrasi::class,'tagihan_administrasi_id');
    }

    public static function getColumns()
    {
        return [
            TextColumn::make('id')
                ->label('ID')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('administrasi.jenisAdministrasi.nama')
                ->label('Administrasi')
                ->searchable()
                ->sortable(),
            TextColumn::make('administrasi.tahun_ajaran')
                ->label('Tahun Ajaran')
                ->searchable()
                ->sortable(),
            TextColumn::make('administrasi.periode')
                ->label('Periode')
                ->searchable()
                ->sortable(),
            TextColumn::make('siswa.nama')
                ->label('Nama Siswa')
                ->searchable()
                ->sortable(),
            TextColumn::make('kelas_sekolah_rombel')
                ->label('Kelas Sekolah')
                ->state(function ($record) {
                    return $record->siswa->kelasRombel;
                })
                ->searchable(['siswa.kelas_sekolah', 'siswa.rombel_kelas_sekolah'])
                ->sortable(['siswa.kelas_sekolah', 'siswa.rombel_kelas_sekolah']),
            TextColumn::make('siswa.kelas_pondok')
                ->label('Kelas Pondok')
                ->searchable()
                ->sortable(),
            TextColumn::make('nominal_tagihan')
                ->label('Nominal Tagihan')
                ->money('IDR')
                ->sortable()
                ->summarize([
                    Sum::make()
                        ->label('Total Tagihan')
                        ->money('IDR')
                ]),
            TextColumn::make('status_tagihan')
                ->label('Status Tagihan')
                ->badge()
                ->searchable()
                ->sortable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('deleted_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function getForm()
    {
        return [
            Select::make('administrasi_id')
                ->label('Administrasi')
                ->relationship('administrasi', 'id')
                ->required()
                ->live(),
            Select::make('siswa_id')
                ->label('Siswa')
                ->relationship(
                    name: 'siswa',
                    titleAttribute: 'nama',
                    modifyQueryUsing: fn (Builder $query, Get $get) =>
                        $query->whereIn('kelas_sekolah', JenisAdministrasi::where('id', $get('jenis_administrasi_id'))->first()?->frekuensi_penagihan->value),
                )
                ->hidden(fn(Get $get) => $get('administrasi_id') == null)
                ->required()
                ->live(),
            TableRepeater::make('nominal_tagihan_administrasi')
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
                        ->prefix('Rp')
                        ->suffix(',00')
                        ->disabled()
                        ->dehydrated(),
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
                ->hidden(fn(Get $get) => $get('administrasi_id') == null && $get('siswa_id') == null)
                ->columnSpanFull(),
            TextInput::make('nominal_tagihan')
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->numeric()
                ->minValue(0)
                ->prefix('Rp')
                ->suffix(',00')
                ->hidden(fn(Get $get) => $get('administrasi_id') == null && $get('siswa_id') == null)
                ->required(),
            ToggleButtons::make('status_tagihan')
                ->label('Status Tagihan')
                ->options(StatusTagihan::class)
                ->default(StatusTagihan::BELUM_BAYAR)
                ->inline()
                ->grouped()
                ->hidden(fn(Get $get) => $get('administrasi_id') != null && $get('siswa_id') != null)
                ->required(),
        ];
    }
}
