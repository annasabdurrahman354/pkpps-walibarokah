<?php

namespace App\Models;

use App\Enums\FrekuensiPenagihan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentClusters\Forms\Cluster;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisAdministrasi extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'jenis_administrasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'frekuensi_penagihan',
        'rekening_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $casts = [
        'frekuensi_penagihan' => FrekuensiPenagihan::class,
    ];

    public function rekening(): BelongsTo
    {
        return $this->belongsTo(Rekening::class,'rekening_id');
    }

    public function administrasi(): HasMany
    {
        return $this->hasMany(Administrasi::class,'jenis_administrasi_id');
    }

    public static function getForm()
    {
        return [
            TextInput::make('nama')
                ->label('Nama')
                ->required(),
            TextInput::make('kode')
                ->label('Kode Administrasi')
                ->minLength(3)
                ->maxLength(3)
                ->helperText('Tuliskan kode jenis administrasi terdiri dari 3 huruf.')
                ->required(),
            ToggleButtons::make('frekuensi_penagihan')
                ->label('Frekuensi Penagihan')
                ->options(FrekuensiPenagihan::class)
                ->grouped()
                ->inline()
                ->required(),
            Select::make('rekening_id')
                ->label('Rekening')
                ->relationship('rekening', 'nama_pemilik')
                ->searchable()
                ->preload()
                ->createOptionForm(Rekening::getForm())
                ->createOptionUsing(function (array $data) {
                    return Rekening::create($data)->getKey();
                })
                ->required()
        ];
    }

    protected static function booted(): void
    {
        parent::boot();
        static::softDeleted(function($record) {
            $record->administrasi()->each(function($administrasi) {
                $administrasi->jenisAdministrasi()->dissociate();
                $administrasi->save();
            });
        });
    }
}
