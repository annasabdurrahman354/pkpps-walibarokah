<?php

namespace App\Models;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'kota_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function kota(): BelongsTo
    {
        return $this->belongsTo(Kota::class);
    }

    public function semuaKelurahan(): HasMany
    {
        return $this->hasMany(Kelurahan::class);
    }

    public static function getForm()
    {
        return [
            Select::make('kota_id')
                ->relationship('kota', 'nama')
                ->searchable()
                ->required(),
            TextInput::make('nama')
                ->required()
                ->maxLength(48),
        ];
    }
}
