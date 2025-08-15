<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\GolonganDarah;
use App\Enums\JenisKelamin;
use App\Enums\Kewarganegaraan;
use App\Enums\PendidikanTerakhir;
use App\Enums\StatusOrangTua;
use App\Enums\StatusUser;
use App\Enums\Unit;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar, HasName, HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use HasRoles, HasPanelShield, HasUlids;
    use InteractsWithMedia, CausesActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'nama_panggilan',
        'jenis_kelamin',
        'kewarganegaraan',
        'unit',
        'nik',
        'nip',
        'nfc',
        'tempat_lahir_id',
        'tanggal_lahir',
        'nomor_telepon',
        'email',
        'tanggal_mulai_tugas',
        'status',
        'pendidikan_terakhir',
        'jurusan',
        'golongan_darah',
        'alamat',
        'provinsi_id',
        'kota_id',
        'kecamatan_id',
        'kelurahan_id',
        'rt',
        'rw',
        'kode_pos',
        'asal_kelompok',
        'asal_desa',
        'asal_daerah',
        'asal_pondok',
        'status_ayah',
        'nama_ayah',
        'nomor_telepon_ayah',
        'status_ibu',
        'nama_ibu',
        'nomor_telepon_ibu',
        'email_verified_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'unit' => 'array',
        'email_verified_at' => 'datetime',
        'tanggal_lahir' => 'date',
        'tanggal_mulai_tugas' => 'date',
        'jenis_kelamin' => JenisKelamin::class,
        'kewarganegaraan' => Kewarganegaraan::class,
        'status' => StatusUser::class,
        'pendidikan_terakhir' => PendidikanTerakhir::class,
        'golongan_darah' => GolonganDarah::class,
        'status_ayah' => StatusOrangTua::class,
        'status_ibu' => StatusOrangTua::class,
    ];

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->getFirstMediaUrl('operator_foto', 'thumb')
            ??
            "https://ui-avatars.com/api/?background=random&size=256&rounded=true&name=".str_replace(" ", "+", $this->nama);
    }

    public function getFilamentName(): string
    {
        return $this->nama;
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->nama,
        );
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Fit::Contain, 256, 256)
            ->nonQueued();
    }

    public function syncMediaName(){
        foreach($this->getMedia('user_foto') as $media){
            $media->file_name = getMediaFilename($this, $media);
            $media->save();
        }
    }

    public function tempatLahir(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'tempat_lahir_id');
    }

    /**
     * Relationship with the 'provinsi' table.
     */
    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    /**
     * Relationship with the 'kota' table.
     */
    public function kota(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'kota_id');
    }

    /**
     * Relationship with the 'kecamatan' table.
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    /**
     * Relationship with the 'kelurahan' table.
     */
    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

    public static function getForm()
    {
        return [
            Section::make('Identitas')
                ->schema([
                    SpatieMediaLibraryFileUpload::make('foto')
                        ->label('Foto')
                        ->avatar()
                        ->collection('user_foto')
                        ->conversion('thumb')
                        ->moveFiles()
                        ->image()
                        ->imageEditor()
                        ->columnSpanFull(),
                    TextInput::make('nama')
                        ->label('Nama Lengkap')
                        ->required(),
                    TextInput::make('nama_panggilan')
                        ->label('Nama Panggilan')
                        ->required(),
                    ToggleButtons::make('jenis_kelamin')
                        ->label('Jenis Kelamin')
                        ->options(JenisKelamin::class)
                        ->inline()
                        ->grouped()
                        ->required(),
                    ToggleButtons::make('kewarganegaraan')
                        ->label('Kewarganegaraan')
                        ->inline()
                        ->grouped()
                        ->options(Kewarganegaraan::class)
                        ->default(Kewarganegaraan::WNI)
                        ->required()
                        ->live(),
                    Select::make('unit')
                        ->label('Unit Kepengurusan')
                        ->multiple()
                        ->options(Unit::class)
                        ->required(),

                    TextInput::make('nik')
                        ->label('Nomor Induk Kependudukan')
                        ->numeric()
                        ->length(16)
                        ->required(fn(Get $get) => $get('kewarganegaraan') == Kewarganegaraan::WNI),
                    TextInput::make('nip')
                        ->label('Nomor Induk Pengurus')
                        ->numeric()
                        ->required(),
                    TextInput::make('nfc')
                        ->label('Kode NFC')
                        ->numeric()
                        ->required(),

                    Select::make('tempat_lahir_id')
                        ->label('Tempat Lahir')
                        ->relationship('tempatLahir', 'nama')
                        ->searchable()
                        ->required(fn(Get $get) => $get('kewarganegaraan') == Kewarganegaraan::WNI),
                    DatePicker::make('tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->required(),
                    DatePicker::make('tanggal_mulai_tugas')
                        ->label('Tanggal Mulai Tugas')
                        ->required()
                        ->default(now()),
                    Select::make('status')
                        ->label('Status')
                        ->options(StatusUser::class)
                        ->default(StatusUser::AKTIF)
                        ->required(),
                ])->columns(2),

            Section::make('Kontak')
                ->schema([
                    TextInput::make('nomor_telepon')
                        ->label('Nomor Telepon')
                        ->maxLength(16)
                        ->tel(),
                    TextInput::make('email')
                        ->label('Email')
                        ->email(),
                ])->columns(2),

            Section::make('Alamat')
                ->schema([
                    Textarea::make('alamat')
                        ->label('Alamat Lengkap')
                        ->rows(3)
                        ->required()
                        ->columnSpanFull(),
                    Select::make('provinsi_id')
                        ->label('Provinsi')
                        ->relationship('provinsi', 'nama')
                        ->searchable()
                        ->required(fn(Get $get) => $get('kewarganegaraan') == Kewarganegaraan::WNI)
                        ->live(),
                    Select::make('kota_id')
                        ->label('Kota/Kabupaten')
                        ->relationship(
                            name: 'kota',
                            titleAttribute: 'nama',
                            modifyQueryUsing: fn (Builder $query, Get $get) =>
                            $query->where('provinsi_id', $get('provinsi_id')),
                        )
                        ->searchable()
                        ->visible(fn (Get $get) => $get('provinsi_id') !== null)
                        ->required(fn(Get $get) => $get('kewarganegaraan') == Kewarganegaraan::WNI)
                        ->live(),
                    Select::make('kecamatan_id')
                        ->label('Kecamatan')
                        ->relationship(
                            name: 'kecamatan',
                            titleAttribute: 'nama',
                            modifyQueryUsing: fn (Builder $query, Get $get) =>
                            $query->where('kota_id', $get('kota_id')),
                        )
                        ->searchable()
                        ->visible(fn (Get $get) => $get('kota_id') !== null)
                        ->required(fn(Get $get) => $get('kewarganegaraan') == Kewarganegaraan::WNI)
                        ->live(),
                    Select::make('kelurahan_id')
                        ->label('Kelurahan')
                        ->relationship(
                            name: 'kelurahan',
                            titleAttribute: 'nama',
                            modifyQueryUsing: fn (Builder $query, Get $get) =>
                            $query->where('kecamatan_id', $get('kecamatan_id')),
                        )
                        ->searchable()
                        ->visible(fn (Get $get) => $get('kecamatan_id') !== null)
                        ->required(fn(Get $get) => $get('kewarganegaraan') == Kewarganegaraan::WNI),
                    TextInput::make('rt')
                        ->label('RT')
                        ->required(fn(Get $get) => $get('kewarganegaraan') == Kewarganegaraan::WNI),
                    TextInput::make('rw')
                        ->label('RW')
                        ->required(fn(Get $get) => $get('kewarganegaraan') == Kewarganegaraan::WNI),
                    TextInput::make('kode_pos')
                        ->label('Kode Pos')
                        ->numeric()
                        ->length(5)
                        ->required(fn(Get $get) => $get('kewarganegaraan') == Kewarganegaraan::WNI),
                    Fieldset::make('Alamat Sambung')
                        ->label('Alamat Sambung')
                        ->schema([
                            TextInput::make('asal_kelompok')
                                ->label('Asal Kelompok')
                                ->required()
                                ->columnSpanFull(),
                            TextInput::make('asal_desa')
                                ->label('Asal Desa')
                                ->required()
                                ->columnSpanFull(),
                            TextInput::make('asal_daerah')
                                ->label('Asal Daerah')
                                ->required()
                                ->columnSpanFull(),
                        ])->columnSpanFull(),
                ])->columns(2),

            Section::make('Informasi Tambahan')
                ->schema([
                    Select::make('pendidikan_terakhir')
                        ->label('Pendidikan Terakhir')
                        ->options(PendidikanTerakhir::class)
                        ->required(fn(Get $get) => $get('kewarganegaraan') == Kewarganegaraan::WNI),
                    TextInput::make('jurusan')
                        ->label('Jurusan'),
                    Select::make('golongan_darah')
                        ->label('Golongan Darah')
                        ->options(GolonganDarah::class)
                        ->default(GolonganDarah::BELUM_DIKETAHUI->value)
                        ->required(),
                ])->columns(2),

            Section::make('Orang Tua')
                ->schema([
                    Select::make('status_ayah')
                        ->label('Status Ayah')
                        ->options(StatusOrangTua::class)
                        ->required()
                        ->live(),
                    TextInput::make('nama_ayah')
                        ->label('Nama Ayah')
                        ->required(fn(Get $get) => $get('status_ayah') == StatusOrangTua::MASIH_HIDUP),
                    TextInput::make('nomor_telepon_ayah')
                        ->label('Nomor Telepon Ayah')
                        ->tel(),
                    Select::make('status_ibu')
                        ->label('Status Ibu')
                        ->options(StatusOrangTua::class)
                        ->required()
                        ->live(),
                    TextInput::make('nama_ibu')
                        ->label('Nama Ibu')
                        ->required(fn(Get $get) => $get('status_ibu') == StatusOrangTua::MASIH_HIDUP),
                    TextInput::make('nomor_telepon_ibu')
                        ->label('Nomor Telepon Ibu')
                        ->tel(),
                ]),
        ];
    }

    public static function getColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label('ID')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            SpatieMediaLibraryImageColumn::make('foto')
                ->label('Foto')
                ->collection('user_foto')
                ->conversion('thumb'),
            TextColumn::make('nama')
                ->label('Nama Lengkap')
                ->searchable()
                ->sortable(),
            TextColumn::make('nama_panggilan')
                ->label('Nama Panggilan')
                ->searchable(),
            TextColumn::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->badge()
                ->sortable(),
            TextColumn::make('kewarganegaraan')
                ->label('Kewarganegaraan')
                ->badge()
                ->sortable(),
            TextColumn::make('unit')
                ->label('Unit Kepengurusan')
                ->badge()
                ->sortable(),
            TextColumn::make('nik')
                ->label('Nomor Induk Kependudukan')
                ->searchable()
                ->sortable(),
            TextColumn::make('nip')
                ->label('Nomor Induk Pengurus')
                ->searchable()
                ->sortable(),
            TextColumn::make('nfc')
                ->label('Kode NFC')
                ->searchable()
                ->sortable(),
            TextColumn::make('tempatLahir.nama')
                ->label('Tempat Lahir')
                ->searchable()
                ->sortable(),
            TextColumn::make('tanggal_lahir')
                ->label('Tanggal Lahir')
                ->date()
                ->sortable(),
            TextColumn::make('nomor_telepon')
                ->label('Nomor Telepon')
                ->searchable()
                ->sortable(),
            TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->sortable(),

            TextColumn::make('tanggal_mulai_tugas')
                ->label('Tanggal Mulai Tugas')
                ->date()
                ->sortable(),
            TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->searchable()
                ->sortable(),
            TextColumn::make('alamat')
                ->label('Alamat Lengkap')
                ->limit(50)
                ->searchable(),
            TextColumn::make('provinsi.nama')
                ->label('Provinsi')
                ->searchable()
                ->sortable(),
            TextColumn::make('kota.nama')
                ->label('Kota/Kabupaten')
                ->searchable()
                ->sortable(),
            TextColumn::make('kecamatan.nama')
                ->label('Kecamatan')
                ->searchable()
                ->sortable(),
            TextColumn::make('kelurahan.nama')
                ->label('Kelurahan')
                ->searchable()
                ->sortable(),
            TextColumn::make('rt')
                ->label('RT')
                ->toggledHiddenByDefault()
                ->sortable(),
            TextColumn::make('rw')
                ->label('RW')
                ->toggledHiddenByDefault()
                ->sortable(),
            TextColumn::make('kode_pos')
                ->label('Kode Pos')
                ->toggledHiddenByDefault()
                ->sortable(),
            TextColumn::make('asal_kelompok')
                ->label('Asal Kelompok')
                ->searchable(),
            TextColumn::make('asal_desa')
                ->label('Asal Desa')
                ->searchable(),
            TextColumn::make('asal_daerah')
                ->label('Asal Daerah')
                ->searchable(),
            TextColumn::make('asal_pondok')
                ->label('Asal Pondok')
                ->searchable(),
            TextColumn::make('pendidikan_terakhir')
                ->label('Pendidikan Terakhir')
                ->badge()
                ->sortable(),
            TextColumn::make('jurusan')
                ->label('Jurusan')
                ->badge()
                ->sortable(),
            TextColumn::make('golongan_darah')
                ->label('Golongan Darah')
                ->sortable(),
            TextColumn::make('status_ayah')
                ->label('Status Ayah')
                ->badge()
                ->sortable(),
            TextColumn::make('nama_ayah')
                ->label('Nama Ibu')
                ->searchable()
                ->sortable(),
            TextColumn::make('nomor_telepon_ayah')
                ->label('Nomor Telepon Ayah')
                ->sortable(),
            TextColumn::make('status_ibu')
                ->label('Status Ibu')
                ->badge()
                ->sortable(),
            TextColumn::make('nama_ibu')
                ->label('Nama Ibu')
                ->searchable()
                ->sortable(),
            TextColumn::make('nomor_telepon_ibu')
                ->label('Nomor Telepon Ibu')
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
}
