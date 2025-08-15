<?php

namespace App\Models;

use App\Enums\MetodePembayaran;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembayaranAdministrasi extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'pembayaran_administrasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tagihan_administrasi_id',
        'tanggal_pembayaran',
        'jumlah_pembayaran',
        'metode_pembayaran',
        'catatan_bendahara',
        'status_verifikasi',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $casts = [
        'tanggal_pembayaran' => 'date',
        'jumlah_pembayaran' => 'integer',
        'metode_pembayaran' => MetodePembayaran::class,
        'status_verifikasi' => 'boolean'
    ];


    public function tagihanAdministrasi(): BelongsTo
    {
        return $this->belongsTo(TagihanAdministrasi::class, 'tagihan_administrasi_id');
    }


    public static function getForm()
    {
        return [
            Select::make('tagihan_administrasi_id')
                ->label('Tagihan Administrasi')
                ->relationship('tagihanAdministrasi', 'id')
                ->required(),
            DatePicker::make('tanggal_pembayaran')
                ->label('Tanggal Pembayaran')
                ->required(),
            TextInput::make('jumlah_pembayaran')
                ->label('Jumlah Pembayaran')
                ->numeric()
                ->required(),
            ToggleButtons::make('metode_pembayaran')
                ->label('Metode Pembayaran')
                ->options(MetodePembayaran::class)
                ->required(),
            Textarea::make('catatan_bendahara')
                ->label('Catatan Bendahara')
                ->rows(3),
            Toggle::make('status_verifikasi')
                ->label('Status Verifikasi')
                ->default(false),
        ];
    }

    public static function getColumns()
    {
        return [
            TextColumn::make('tagihanAdministrasi.administrasi.jenisAdministrasi.nama')
                ->label('Administrasi')
                ->searchable()
                ->sortable(),
            TextColumn::make('tagihanAdministrasi.administrasi.tahun_ajaran')
                ->label('Tahun Ajaran')
                ->searchable()
                ->sortable(),
            TextColumn::make('tagihanAdministrasi.administrasi.periode')
                ->label('Periode')
                ->searchable()
                ->sortable(),

            TextColumn::make('tagihanAdministrasi.siswa.nama')
                ->label('Nama Siswa')
                ->searchable()
                ->sortable(),

            TextColumn::make('kelas_sekolah_rombel')
                ->label('Kelas Sekolah')
                ->state(function ($record) {
                    return $record->tagihanAdministrasi->siswa->kelasRombel;
                })
                ->searchable(['tagihanAdministrasi.siswa.kelas_sekolah', 'tagihanAdministrasi.siswa.rombel_kelas_sekolah'])
                ->sortable(['tagihanAdministrasi.siswa.kelas_sekolah', 'tagihanAdministrasi.siswa.rombel_kelas_sekolah']),

            TextColumn::make('tagihanAdministrasi.siswa.kelas_pondok')
                ->label('Kelas Pondok')
                ->searchable()
                ->sortable(),

            TextColumn::make('tanggal_pembayaran')
                ->label('Tanggal Pembayaran')
                ->date()
                ->sortable(),

           TextColumn::make('jumlah_pembayaran')
               ->label('Jumlah Pembayaran')
               ->money('IDR')
               ->sortable(),

            TextColumn::make('metode_pembayaran')
                ->label('Metode Pembayaran')
                ->badge()
                ->searchable()
                ->sortable(),

            TextColumn::make('catatan_bendahara')
                ->label('Catatan Bendahara')
                ->limit(50),

            IconColumn::make('status_verifikasi')
                ->label('Status Verifikasi')
                ->boolean()
                ->sortable(),
        ];
    }
}
