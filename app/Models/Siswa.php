<?php

namespace App\Models;

use App\Enums\CitaCita;
use App\Enums\GolonganDarah;
use App\Enums\Hobi;
use App\Enums\HubunganWali;
use App\Enums\JenisKelamin;
use App\Enums\JenjangSekolah;
use App\Enums\KategoriAdministrasi;
use App\Enums\KebutuhanDisabilitas;
use App\Enums\KebutuhanKhusus;
use App\Enums\KelasPondok;
use App\Enums\KelasSekolah;
use App\Enums\KepemilikanRumah;
use App\Enums\Kewarganegaraan;
use App\Enums\Pekerjaan;
use App\Enums\PekerjaanLakilaki;
use App\Enums\PekerjaanPerempuan;
use App\Enums\PendidikanTerakhir;
use App\Enums\Penghasilan;
use App\Enums\StatusMukim;
use App\Enums\StatusOrangTua;
use App\Enums\StatusSiswa;
use App\Enums\StatusTinggal;
use App\Enums\SumberPembiayaan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    use SoftDeletes, HasUlids;

    // The table associated with the model.
    protected $table = 'siswa';

    // The attributes that are mass assignable.
    protected $fillable = [
        'nama',
        'nama_panggilan',
        'jenis_kelamin',
        'nik',
        'nis',
        'nism',
        'nisn',
        'nfc',
        'kewarganegaraan',
        'tempat_lahir_id',
        'tanggal_lahir',
        'nomor_telepon',
        'email',
        'pendidikan_terakhir',
        'jenjang_sekolah',
        'kelas_sekolah',
        'rombel_kelas_sekolah',
        'kelas_pondok',
        'tanggal_masuk',
        'kategori_administrasi',
        'sumber_pembiayaan',
        'status_siswa',
        'status_mukim',
        'status_tinggal',
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
        'golongan_darah',
        'riwayat_penyakit',
        'kebutuhan_khusus',
        'kebutuhan_diabilitas',
        'cita_cita',
        'hobi',
        'nomor_kk',
        'nama_kepala_keluarga',
        'jumlah_saudara',
        'anak_nomor',
        'nomor_kip',
        'tahun_penerimaan_kip',
        'status_ayah',
        'nama_ayah',
        'kewarganegaraan_ayah',
        'nik_ayah',
        'tempat_lahir_ayah_id',
        'tanggal_lahir_ayah',
        'nomor_telepon_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'pendidikan_terakhir_ayah',
        'ayah_tinggal_luar_negeri',
        'alamat_ayah',
        'provinsi_ayah_id',
        'kota_ayah_id',
        'kecamatan_ayah_id',
        'kelurahan_ayah_id',
        'rt_ayah',
        'rw_ayah',
        'kode_pos_ayah',
        'kepemilikan_rumah_ayah',
        'status_ibu',
        'nama_ibu',
        'kewarganegaraan_ibu',
        'nik_ibu',
        'kk_sama_dengan_ayah',
        'tempat_lahir_ibu_id',
        'tanggal_lahir_ibu',
        'nomor_telepon_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'pendidikan_terakhir_ibu',
        'alamat_ibu_sama_dengan_ayah',
        'ibu_tinggal_luar_negeri',
        'alamat_ibu',
        'provinsi_ibu_id',
        'kota_ibu_id',
        'kecamatan_ibu_id',
        'kelurahan_ibu_id',
        'rt_ibu',
        'rw_ibu',
        'kode_pos_ibu',
        'kepemilikan_rumah_ibu',
        'hubungan_wali',
        'nama_wali',
        'jenis_kelamin_wali',
        'kewarganegaraan_wali',
        'nik_wali',
        'tempat_lahir_wali_id',
        'tanggal_lahir_wali',
        'nomor_telepon_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'pendidikan_terakhir_wali',
        'wali_tinggal_luar_negeri',
        'alamat_wali',
        'provinsi_wali_id',
        'kota_wali_id',
        'kecamatan_wali_id',
        'kelurahan_wali_id',
        'rt_wali',
        'rw_wali',
        'kode_pos_wali',
        'kepemilikan_rumah_wali',
        'password',
    ];

    // The attributes that should be hidden for arrays.
    protected $hidden = [
        'password', 'remember_token', 'email_verified_at', 'deleted_at'
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_lahir' => 'date',
        'tanggal_lahir_ayah' => 'date',
        'tanggal_lahir_ibu' => 'date',
        'tanggal_lahir_wali' => 'date',
        'riwayat_penyakit' => 'array',
        'ayah_tinggal_luar_negeri' => 'boolean',
        'ibu_tinggal_luar_negeri' => 'boolean',
        'wali_tinggal_luar_negeri' => 'boolean',
        'kk_sama_dengan_ayah' => 'boolean',
        'alamat_sama_dengan_ayah' => 'boolean',
        'jenis_kelamin' => JenisKelamin::class,
        'jenjang_sekolah' => JenjangSekolah::class,
        'kelas_pondok' => KelasPondok::class,
        'kategori_administrasi' => KategoriAdministrasi::class,
        'status_siswa' => StatusSiswa::class,
        'golongan_darah' => GolonganDarah::class,
        'kebutuhan_khusus' => KebutuhanKhusus::class,
        'kebutuhan_diabilitas' => KebutuhanDisabilitas::class,
        'status_mukim' => StatusMukim::class,
        'status_tinggal' => StatusTinggal::class,
        'sumber_pembiayaan' => SumberPembiayaan::class,
        'cita_cita' => CitaCita::class,
        'hobi' => Hobi::class,
        'status_ayah' => StatusOrangTua::class,
        'status_ibu' => StatusOrangTua::class,
        'kewarganegaraan' => Kewarganegaraan::class,
        'kewarganegaraan_ayah' => Kewarganegaraan::class,
        'kewarganegaraan_ibu' => Kewarganegaraan::class,
        'kewarganegaraan_wali' => Kewarganegaraan::class,
        'pendidikan_terakhir' => PendidikanTerakhir::class,
        'pendidikan_terakhir_ayah' => PendidikanTerakhir::class,
        'pendidikan_terakhir_ibu' => PendidikanTerakhir::class,
        'pendidikan_terakhir_wali' => PendidikanTerakhir::class,
        'penghasilan_ayah' => Penghasilan::class,
        'penghasilan_ibu' => Penghasilan::class,
        'penghasilan_wali' => Penghasilan::class,
        'kepemilikan_rumah_ayah' => KepemilikanRumah::class,
        'kepemilikan_rumah_ibu' => KepemilikanRumah::class,
        'kepemilikan_rumah_wali' => KepemilikanRumah::class,
        'pekerjaan_ayah' => PekerjaanLakilaki::class,
        'pekerjaan_ibu' => PekerjaanPerempuan::class,
        'pekerjaan_wali' => Pekerjaan::class,
        'hubungan_wali' => HubunganWali::class,
        'jenis_kelamin_wali' => JenisKelamin::class,
    ];

    // The attributes that should be treated as dates.
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Relationships
    public function tempatLahir(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'tempat_lahir_id');
    }

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kota(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'kota_id');
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

    public function tempatLahirAyah(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'tempat_lahir_ayah_id');
    }

    public function provinsiAyah(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_ayah_id');
    }

    public function kotaAyah(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'kota_ayah_id');
    }

    public function kecamatanAyah(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_ayah_id');
    }

    public function kelurahanAyah(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_ayah_id');
    }

    public function tempatLahirIbu(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'tempat_lahir_ibu_id');
    }

    public function provinsiIbu(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_ibu_id');
    }

    public function kotaIbu(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'kota_ibu_id');
    }

    public function kecamatanIbu(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_ibu_id');
    }

    public function kelurahanIbu(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_ibu_id');
    }

    public function provinsiWali(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_wali_id');
    }

    public function tempatLahirWali(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'tempat_lahir_wali_id');
    }

    public function kotaWali(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'kota_wali_id');
    }

    public function kecamatanWali(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_wali_id');
    }

    public function kelurahanWali(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_wali_id');
    }

    public static function getFormSchema(): array
    {
        return [
            Tabs::make('Data Siswa')
                ->tabs([
                    Tab::make('Informasi Pribadi')
                        ->schema([
                            Section::make('Identitas')
                                ->schema([
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

                                    TextInput::make('nik')
                                        ->label('Nomor Induk Kependudukan')
                                        ->numeric()
                                        ->length(16)
                                        ->required(fn(Get $get) => $get('kewarganegaraan') == Kewarganegaraan::WNI),
                                    TextInput::make('nis')
                                        ->label('Nomor Induk Siswa')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('nism')
                                        ->label('Nomor Induk Siswa Madrasah')
                                        ->numeric()
                                        ->length(18)
                                        ->required(),
                                    TextInput::make('nisn')
                                        ->label('Nomor Induk Siswa Nasional')
                                        ->numeric()
                                        ->length(10)
                                        ->required(fn(Get $get) => $get('kewarganegaraan') == Kewarganegaraan::WNI),
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

                            Section::make('Sekolah & Pondok Pesantren')
                                ->schema([
                                    Select::make('pendidikan_terakhir')
                                        ->label('Pendidikan Terakhir')
                                        ->options(PendidikanTerakhir::class)
                                        ->required(fn(Get $get) => $get('kewarganegaraan') == Kewarganegaraan::WNI),
                                    ToggleButtons::make('jenjang_sekolah')
                                        ->label('Jenjang Sekolah')
                                        ->options(JenjangSekolah::class)
                                        ->inline()
                                        ->grouped()
                                        ->required(),
                                    Fieldset::make('Kelas Sekolah')
                                        ->label('Kelas Sekolah')
                                        ->schema([
                                            Select::make('kelas_sekolah')
                                                ->label('Kelas')
                                                ->options(KelasSekolah::class)
                                                ->required(),
                                            TextInput::make('rombel_kelas_sekolah')
                                                ->label('Rombel')
                                                ->length(1)
                                                ->required(),
                                        ]),
                                    Select::make('kelas_pondok')
                                        ->label('Kelas Pondok')
                                        ->options(KelasPondok::class)
                                        ->required(),
                                    DatePicker::make('tanggal_masuk')
                                        ->label('Tanggal Masuk')
                                        ->required()
                                        ->default(now()),
                                ])->columns(2),

                            Section::make('Administrasi')
                                ->schema([
                                    Select::make('kategori_administrasi')
                                        ->label('Kategori Administrasi')
                                        ->options(KategoriAdministrasi::class)
                                        ->required(),
                                    Select::make('sumber_pembiayaan')
                                        ->label('Sumber Pembiayaan')
                                        ->options(SumberPembiayaan::class)
                                        ->default(SumberPembiayaan::ORANG_TUA)
                                        ->required(),
                                    Select::make('status_siswa')
                                        ->label('Status Siswa')
                                        ->options(StatusSiswa::class)
                                        ->default(StatusSiswa::AKTIF)
                                        ->required(),
                                ])->columns(2),

                            Section::make('Alamat')
                                ->schema([
                                    Select::make('status_mukim')
                                        ->label('Status Mukim')
                                        ->options(StatusMukim::class)
                                        ->default(StatusMukim::MUKIM->value)
                                        ->required(),
                                    Select::make('status_tinggal')
                                        ->label('Status Tinggal')
                                        ->options(StatusTinggal::class)
                                        ->default(StatusTinggal::BERSAMA_ORANG_TUA->value)
                                        ->required(),
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
                                    Select::make('golongan_darah')
                                        ->label('Golongan Darah')
                                        ->options(GolonganDarah::class)
                                        ->default(GolonganDarah::BELUM_DIKETAHUI->value)
                                        ->required(),
                                    TagsInput::make('riwayat_penyakit')
                                        ->label('Riwayat Penyakit'),
                                    Select::make('kebutuhan_khusus')
                                        ->label('Kebutuhan Khusus')
                                        ->options(KebutuhanKhusus::class)
                                        ->default(KebutuhanKhusus::TIDAK_ADA->value)
                                        ->required(),
                                    Select::make('kebutuhan_disabilitas')
                                        ->label('Kebutuhan Disabilitas')
                                        ->default(KebutuhanDisabilitas::class)
                                        ->default(KebutuhanDisabilitas::TIDAK_ADA->value)
                                        ->required(),
                                    Select::make('cita_cita')
                                        ->label('Cita-cita')
                                        ->options(CitaCita::class),
                                    Select::make('hobi')
                                        ->label('Hobi')
                                        ->options(Hobi::class),
                                ])->columns(2),
                        ]),

                    Tab::make('Informasi Keluarga')
                        ->schema([
                            Section::make('Informasi Keluarga')
                                ->schema([
                                    TextInput::make('nomor_kk')
                                        ->label('Nomor Kartu Keluarga')
                                        ->numeric()
                                        ->length(16),
                                    TextInput::make('nama_kepala_keluarga')
                                        ->label('Nama Kepala Keluarga'),
                                    TextInput::make('jumlah_saudara')
                                        ->label('Jumlah Saudara')
                                        ->numeric()
                                        ->step(1)
                                        ->minValue(0),
                                    TextInput::make('anak_nomor')
                                        ->label('Anak Ke-')
                                        ->numeric()
                                        ->step(1)
                                        ->minValue(1),
                                    TextInput::make('nomor_kip')
                                        ->label('Nomor Kartu Indonesia Pintar (KIP)'),
                                    TextInput::make('tahun_penerimaan_kip')
                                        ->label('Tahun Penerimaan KIP')
                                        ->numeric()
                                        ->placeholder('Masukkan tahun penerimaan KIP')
                                        ->minValue(1900)
                                        ->maxValue((int) date('Y')), // Limit to current year or earlier
                                ])
                                ->columns(2),

                            Section::make('Ayah')
                                ->schema([
                                    Section::make('Identitas Ayah')
                                        ->schema([
                                            Select::make('status_ayah')
                                                ->label('Status')
                                                ->options(StatusOrangTua::class)
                                                ->required()
                                                ->live(),
                                            TextInput::make('nama_ayah')
                                                ->label('Nama')
                                                ->required(fn(Get $get) => $get('status_ayah') == StatusOrangTua::MASIH_HIDUP),
                                            ToggleButtons::make('kewarganegaraan_ayah')
                                                ->label('Kewarganegaraan')
                                                ->inline()
                                                ->grouped()
                                                ->options(Kewarganegaraan::class)
                                                ->default(Kewarganegaraan::WNI)
                                                ->required(fn(Get $get) => $get('status_ayah') == StatusOrangTua::MASIH_HIDUP)
                                                ->live(),
                                            TextInput::make('nik_ayah')
                                                ->label('Nomor Induk Kependudukan')
                                                ->length(16)
                                                ->required(fn(Get $get) => $get('status_ayah') == StatusOrangTua::MASIH_HIDUP && $get('kewarganegaraan_ayah') == Kewarganegaraan::WNI),
                                            Select::make('tempat_lahir_ayah_id')
                                                ->label('Tempat Lahir')
                                                ->relationship('tempatLahirAyah', 'nama')
                                                ->searchable()
                                                ->required(fn(Get $get) => $get('status_ayah') == StatusOrangTua::MASIH_HIDUP && $get('kewarganegaraan_ayah') == Kewarganegaraan::WNI),
                                            DatePicker::make('tanggal_lahir_ayah')
                                                ->label('Tanggal Lahir')
                                                ->required(fn(Get $get) => $get('status_ayah') == StatusOrangTua::MASIH_HIDUP),
                                            TextInput::make('nomor_telepon_ayah')
                                                ->label('Nomor Telepon')
                                                ->tel(),
                                            Select::make('pekerjaan_ayah')
                                                ->label('Pekerjaan')
                                                ->options(PekerjaanLakilaki::class)
                                                ->required(fn(Get $get) => $get('status_ayah') == StatusOrangTua::MASIH_HIDUP),
                                            Select::make('penghasilan_ayah')
                                                ->label('Penghasilan')
                                                ->options(Penghasilan::class)
                                                ->required(fn(Get $get) => $get('status_ayah') == StatusOrangTua::MASIH_HIDUP),
                                            Select::make('pendidikan_terakhir_ayah')
                                                ->label('Pendidikan Terakhir')
                                                ->options(PendidikanTerakhir::class)
                                                ->required(fn(Get $get) => $get('status_ayah') == StatusOrangTua::MASIH_HIDUP && $get('kewarganegaraan_ayah') == Kewarganegaraan::WNI),
                                        ]),

                                    Section::make('Alamat Ayah')
                                        ->schema([
                                            Toggle::make('ayah_tinggal_luar_negeri')
                                                ->label('Tinggal di Luar Negeri')
                                                ->default(false)
                                                ->required(fn(Get $get) => $get('status_ayah') == StatusOrangTua::MASIH_HIDUP)
                                                ->live(),
                                            Textarea::make('alamat_ayah')
                                                ->label('Alamat Lengkap')
                                                ->rows(3)
                                                ->required(fn(Get $get) => $get('status_ayah') == StatusOrangTua::MASIH_HIDUP)
                                                ->columnSpanFull(),
                                            Select::make('provinsi_ayah_id')
                                                ->label('Provinsi')
                                                ->relationship('provinsiAyah', 'nama')
                                                ->searchable()
                                                ->required(fn(Get $get) => ($get('status_ayah') == StatusOrangTua::MASIH_HIDUP) && ($get('ayah_tinggal_luar_negeri') == false))
                                                ->live(),
                                            Select::make('kota_ayah_id')
                                                ->label('Kota/Kabupaten')
                                                ->relationship(
                                                    name: 'kotaAyah',
                                                    titleAttribute: 'nama',
                                                    modifyQueryUsing: fn (Builder $query, Get $get) =>
                                                    $query->where('provinsi_ayah_id', $get('provinsi_ayah_id')),
                                                )
                                                ->searchable()
                                                ->visible(fn (Get $get) => $get('provinsi_ayah_id') !== null)
                                                ->required(fn(Get $get) => ($get('status_ayah') == StatusOrangTua::MASIH_HIDUP) && ($get('ayah_tinggal_luar_negeri') == false))
                                                ->live(),
                                            Select::make('kecamatan_ayah_id')
                                                ->label('Kecamatan')
                                                ->relationship(
                                                    name: 'kecamatanAyah',
                                                    titleAttribute: 'nama',
                                                    modifyQueryUsing: fn (Builder $query, Get $get) =>
                                                    $query->where('kota_ayah_id', $get('kota_ayah_id')),
                                                )
                                                ->searchable()
                                                ->visible(fn (Get $get) => $get('kota_ayah_id') !== null)
                                                ->required(fn(Get $get) => ($get('status_ayah') == StatusOrangTua::MASIH_HIDUP) && ($get('ayah_tinggal_luar_negeri') == false))
                                                ->live(),
                                            Select::make('kelurahan_ayah_id')
                                                ->label('Kelurahan')
                                                ->relationship(
                                                    name: 'kelurahanAyah',
                                                    titleAttribute: 'nama',
                                                    modifyQueryUsing: fn (Builder $query, Get $get) =>
                                                    $query->where('kecamatan_ayah_id', $get('kecamatan_ayah_id')),
                                                )
                                                ->searchable()
                                                ->visible(fn (Get $get) => $get('kecamatan_ayah_id') !== null)
                                                ->required(fn(Get $get) => ($get('status_ayah') == StatusOrangTua::MASIH_HIDUP) && ($get('ayah_tinggal_luar_negeri') == false)),
                                            TextInput::make('rt_ayah')
                                                ->label('RT')
                                                ->required(fn(Get $get) => ($get('status_ayah') == StatusOrangTua::MASIH_HIDUP) && ($get('ayah_tinggal_luar_negeri') == false)),
                                            TextInput::make('rw_ayah')
                                                ->label('RW')
                                                ->required(fn(Get $get) => ($get('status_ayah') == StatusOrangTua::MASIH_HIDUP) && ($get('ayah_tinggal_luar_negeri') == false)),
                                            TextInput::make('kode_pos_ayah')
                                                ->label('Kode Pos')
                                                ->numeric()
                                                ->length(5)
                                                ->required(fn(Get $get) => ($get('status_ayah') == StatusOrangTua::MASIH_HIDUP) && ($get('ayah_tinggal_luar_negeri') == false)),
                                            Select::make('kepemilikan_rumah_ayah')
                                                ->label('Kepemilikan Rumah')
                                                ->options(KepemilikanRumah::class)
                                                ->default(KepemilikanRumah::MILIK_SENDIRI->value)
                                                ->required(fn(Get $get) => ($get('status_ayah') == StatusOrangTua::MASIH_HIDUP) && ($get('ayah_tinggal_luar_negeri') == false)),
                                        ])->columns(2),
                                ])->columns(2),

                            Section::make('Ibu')
                                ->schema([
                                    Section::make('Identitas Ibu')
                                        ->schema([
                                            Select::make('status_ibu')
                                                ->label('Status')
                                                ->options(StatusOrangTua::class)
                                                ->required()
                                                ->live(),
                                            TextInput::make('nama_ibu')
                                                ->label('Nama')
                                                ->required(fn(Get $get) => $get('status_ibu') == StatusOrangTua::MASIH_HIDUP),
                                            ToggleButtons::make('kewarganegaraan_ibu')
                                                ->label('Kewarganegaraan')
                                                ->inline()
                                                ->grouped()
                                                ->options(Kewarganegaraan::class)
                                                ->default(Kewarganegaraan::WNI)
                                                ->required(fn(Get $get) => $get('status_ibu') == StatusOrangTua::MASIH_HIDUP)
                                                ->live(),
                                            TextInput::make('nik_ibu')
                                                ->label('Nomor Induk Kependudukan')
                                                ->numeric()
                                                ->length(16)
                                                ->required(fn(Get $get) => $get('status_ibu') == StatusOrangTua::MASIH_HIDUP && $get('kewarganegaraan_ibu') == Kewarganegaraan::WNI),
                                            Toggle::make('kk_sama_dengan_ayah')
                                                ->label('Kartu Keluarga Sama dengan Ayah')
                                                ->required(fn(Get $get) => $get('status_ibu') == StatusOrangTua::MASIH_HIDUP && $get('kewarganegaraan_ibu') == Kewarganegaraan::WNI),
                                            Select::make('tempat_lahir_ibu_id')
                                                ->label('Tempat Lahir')
                                                ->relationship('tempatLahirIbu', 'nama')
                                                ->searchable()
                                                ->required(fn(Get $get) => $get('status_ibu') == StatusOrangTua::MASIH_HIDUP && $get('kewarganegaraan_ibu') == Kewarganegaraan::WNI),
                                            DatePicker::make('tanggal_lahir_ibu')
                                                ->label('Tanggal Lahir')
                                                ->required(fn(Get $get) => $get('status_ibu') == StatusOrangTua::MASIH_HIDUP),
                                            TextInput::make('nomor_telepon_ibu')
                                                ->label('Nomor Telepon')
                                                ->tel(),
                                            Select::make('pekerjaan_ibu')
                                                ->label('Pekerjaan')
                                                ->options(PekerjaanPerempuan::class)
                                                ->required(fn(Get $get) => $get('status_ibu') == StatusOrangTua::MASIH_HIDUP),
                                            Select::make('penghasilan_ibu')
                                                ->label('Penghasilan')
                                                ->options(Penghasilan::class)
                                                ->required(fn(Get $get) => $get('status_ibu') == StatusOrangTua::MASIH_HIDUP),
                                            Select::make('pendidikan_terakhir_ibu')
                                                ->label('Pendidikan Terakhir')
                                                ->options(PendidikanTerakhir::class)
                                                ->required(fn(Get $get) => $get('status_ibu') == StatusOrangTua::MASIH_HIDUP && $get('kewarganegaraan_ibu') == Kewarganegaraan::WNI),
                                        ]),

                                    Section::make('Alamat Ibu')
                                        ->schema([
                                            Toggle::make('alamat_ibu_sama_dengan_ayah')
                                                ->label('Alamat Sama dengan Ayah')
                                                ->default(true)
                                                ->required(fn(Get $get) => $get('status_ibu') == StatusOrangTua::MASIH_HIDUP)
                                                ->live(),
                                            Toggle::make('ibu_tinggal_luar_negeri')
                                                ->label('Tinggal di Luar Negeri')
                                                ->default(false)
                                                ->visible(fn(Get $get) => $get('alamat_ibu_sama_dengan_ayah') == false)
                                                ->required(fn(Get $get) => $get('status_ibu') == StatusOrangTua::MASIH_HIDUP)
                                                ->live(),
                                            Textarea::make('alamat_ibu')
                                                ->label('Alamat Lengkap')
                                                ->rows(3)
                                                ->visible(fn(Get $get) => $get('alamat_ibu_sama_dengan_ayah') == false)
                                                ->required(fn(Get $get) => $get('status_ibu') == StatusOrangTua::MASIH_HIDUP)
                                                ->columnSpanFull(),
                                            Select::make('provinsi_ibu_id')
                                                ->label('Provinsi')
                                                ->relationship('provinsi', 'nama')
                                                ->searchable()
                                                ->visible(fn(Get $get) => $get('alamat_ibu_sama_dengan_ayah') == false)
                                                ->required(fn(Get $get) => ($get('status_ibu') == StatusOrangTua::MASIH_HIDUP) && ($get('ibu_tinggal_luar_negeri') == false))
                                                ->live(),
                                            Select::make('kota_ibu_id')
                                                ->label('Kota/Kabupaten')
                                                ->relationship(
                                                    name: 'kotaIbu',
                                                    titleAttribute: 'nama',
                                                    modifyQueryUsing: fn (Builder $query, Get $get) =>
                                                    $query->where('provinsi_ibu_id', $get('provinsi_ibu_id')),
                                                )
                                                ->searchable()
                                                ->visible(fn(Get $get) => $get('alamat_ibu_sama_dengan_ayah') == false && $get('provinsi_ibu_id') !== null)
                                                ->required(fn(Get $get) => ($get('status_ibu') == StatusOrangTua::MASIH_HIDUP) && ($get('ibu_tinggal_luar_negeri') == false))
                                                ->live(),
                                            Select::make('kecamatan_ibu_id')
                                                ->label('Kecamatan')
                                                ->relationship(
                                                    name: 'kecamatanIbu',
                                                    titleAttribute: 'nama',
                                                    modifyQueryUsing: fn (Builder $query, Get $get) =>
                                                    $query->where('kota_ibu_id', $get('kota_ibu_id')),
                                                )
                                                ->searchable()
                                                ->visible(fn(Get $get) => $get('alamat_ibu_sama_dengan_ayah') == false && $get('kota_ibu_id') !== null)
                                                ->required(fn(Get $get) => ($get('status_ibu') == StatusOrangTua::MASIH_HIDUP) && ($get('ibu_tinggal_luar_negeri') == false))
                                                ->live(),
                                            Select::make('kelurahan_ibu_id')
                                                ->label('Kelurahan')
                                                ->relationship(
                                                    name: 'kelurahanIbu',
                                                    titleAttribute: 'nama',
                                                    modifyQueryUsing: fn (Builder $query, Get $get) =>
                                                    $query->where('kecamatan_ibu_id', $get('kecamatan_ibu_id')),
                                                )
                                                ->searchable()
                                                ->visible(fn(Get $get) => $get('alamat_ibu_sama_dengan_ayah') == false && $get('kecamatan_ibu_id') !== null)
                                                ->required(fn(Get $get) => ($get('status_ibu') == StatusOrangTua::MASIH_HIDUP) && ($get('ibu_tinggal_luar_negeri') == false)),
                                            TextInput::make('rt_ibu')
                                                ->label('RT')
                                                ->visible(fn(Get $get) => $get('alamat_ibu_sama_dengan_ayah') == false)
                                                ->required(fn(Get $get) => ($get('status_ibu') == StatusOrangTua::MASIH_HIDUP) && ($get('ibu_tinggal_luar_negeri') == false)),
                                            TextInput::make('rw_ibu')
                                                ->label('RW')
                                                ->visible(fn(Get $get) => $get('alamat_ibu_sama_dengan_ayah') == false)
                                                ->required(fn(Get $get) => ($get('status_ibu') == StatusOrangTua::MASIH_HIDUP) && ($get('ibu_tinggal_luar_negeri') == false)),
                                            TextInput::make('kode_pos_ibu')
                                                ->label('Kode Pos')
                                                ->numeric()
                                                ->length(5)
                                                ->visible(fn(Get $get) => $get('alamat_ibu_sama_dengan_ayah') == false)
                                                ->required(fn(Get $get) => ($get('status_ibu') == StatusOrangTua::MASIH_HIDUP) && ($get('ibu_tinggal_luar_negeri') == false)),
                                            Select::make('kepemilikan_rumah_ibu')
                                                ->label('Kepemilikan Rumah')
                                                ->options(KepemilikanRumah::class)
                                                ->default(KepemilikanRumah::MILIK_SENDIRI->value)
                                                ->visible(fn(Get $get) => $get('alamat_ibu_sama_dengan_ayah') == false)
                                                ->required(fn(Get $get) => ($get('status_ibu') == StatusOrangTua::MASIH_HIDUP) && ($get('ibu_tinggal_luar_negeri') == false)),
                                        ])->columns(2),
                                ])->columns(2),

                            Section::make('Wali')
                                ->schema([
                                    Section::make('Identitas Wali')
                                        ->schema([
                                            Select::make('hubungan_wali')
                                                ->label('Hubungan Wali')
                                                ->options(HubunganWali::class)
                                                ->default(HubunganWali::AYAH)
                                                ->required()
                                                ->live(),
                                            TextInput::make('nama_wali')
                                                ->label('Nama')
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA])),
                                            ToggleButtons::make('jenis_kelamin')
                                                ->label('Jenis Kelamin')
                                                ->options(JenisKelamin::class)
                                                ->inline()
                                                ->grouped()
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA])),
                                            ToggleButtons::make('kewarganegaraan_wali')
                                                ->label('Kewarganegaraan')
                                                ->inline()
                                                ->grouped()
                                                ->options(Kewarganegaraan::class)
                                                ->default(Kewarganegaraan::WNI)
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required()
                                                ->live(),
                                            TextInput::make('nik_wali')
                                                ->label('Nomor Induk Kependudukan')
                                                ->numeric()
                                                ->length(16)
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required(fn(Get $get) => $get('kewarganegaraan_wali') == Kewarganegaraan::WNI),
                                            Select::make('tempat_lahir_wali_id')
                                                ->label('Tempat Lahir')
                                                ->relationship('tempatLahirWali', 'nama')
                                                ->searchable()
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required(fn(Get $get) => $get('kewarganegaraan_wali') == Kewarganegaraan::WNI),
                                            DatePicker::make('tanggal_lahir_wali')
                                                ->label('Tanggal Lahir')
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required(),
                                            TextInput::make('nomor_telepon_wali')
                                                ->label('Nomor Telepon')
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->tel(),
                                            Select::make('pekerjaan_wali')
                                                ->label('Pekerjaan')
                                                ->options(Pekerjaan::class)
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required(),
                                            Select::make('penghasilan_wali')
                                                ->label('Penghasilan')
                                                ->options(Penghasilan::class)
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required(),
                                            Select::make('pendidikan_terakhir_wali')
                                                ->label('Pendidikan Terakhir')
                                                ->options(PendidikanTerakhir::class)
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required(fn(Get $get) => $get('kewarganegaraan_wali') == Kewarganegaraan::WNI),
                                        ]),

                                    Section::make('Alamat Wali')
                                        ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                        ->schema([
                                            Toggle::make('wali_tinggal_luar_negeri')
                                                ->label('Tinggal di Luar Negeri')
                                                ->default(false)
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required()
                                                ->live(),
                                            Textarea::make('alamat_wali')
                                                ->label('Alamat Lengkap')
                                                ->rows(3)
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required()
                                                ->columnSpanFull(),
                                            Select::make('provinsi_wali_id')
                                                ->label('Provinsi')
                                                ->relationship('provinsi', 'nama')
                                                ->searchable()
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required(fn(Get $get) => ($get('wali_tinggal_luar_negeri') == false))
                                                ->live(),
                                            Select::make('kota_wali_id')
                                                ->label('Kota/Kabupaten')
                                                ->relationship(
                                                    name: 'kotaWali',
                                                    titleAttribute: 'nama',
                                                    modifyQueryUsing: fn (Builder $query, Get $get) =>
                                                    $query->where('provinsi_wali_id', $get('provinsi_wali_id')),
                                                )
                                                ->searchable()
                                                ->visible(fn(Get $get) => $get('provinsi_wali_id') !== null && in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required(fn(Get $get) => ($get('wali_tinggal_luar_negeri') == false))
                                                ->live(),
                                            Select::make('kecamatan_wali_id')
                                                ->label('Kecamatan')
                                                ->relationship(
                                                    name: 'kecamatanWali',
                                                    titleAttribute: 'nama',
                                                    modifyQueryUsing: fn (Builder $query, Get $get) =>
                                                    $query->where('kota_wali_id', $get('kota_wali_id')),
                                                )
                                                ->searchable()
                                                ->visible(fn(Get $get) => $get('kota_wali_id') !== null && in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required(fn(Get $get) => ($get('wali_tinggal_luar_negeri') == false))
                                                ->live(),
                                            Select::make('kelurahan_wali_id')
                                                ->label('Kelurahan')
                                                ->relationship(
                                                    name: 'kelurahanWali',
                                                    titleAttribute: 'nama',
                                                    modifyQueryUsing: fn (Builder $query, Get $get) =>
                                                    $query->where('kecamatan_wali_id', $get('kecamatan_wali_id')),
                                                )
                                                ->searchable()
                                                ->visible(fn(Get $get) => $get('kecamatan_wali_id') !== null && in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required(fn(Get $get) => ($get('wali_tinggal_luar_negeri') == false)),
                                            TextInput::make('rt_wali')
                                                ->label('RT')
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required(fn(Get $get) => ($get('wali_tinggal_luar_negeri') == false)),
                                            TextInput::make('rw_wali')
                                                ->label('RW')
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required(fn(Get $get) => ($get('wali_tinggal_luar_negeri') == false)),
                                            TextInput::make('kode_pos_wali')
                                                ->label('Kode Pos')
                                                ->numeric()
                                                ->length(5)
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required(fn(Get $get) => ($get('wali_tinggal_luar_negeri') == false)),
                                            Select::make('kepemilikan_rumah_wali')
                                                ->label('Kepemilikan Rumah')
                                                ->options(KepemilikanRumah::class)
                                                ->default(KepemilikanRumah::MILIK_SENDIRI->value)
                                                ->visible(fn(Get $get) => in_array($get('hubungan_wali'), [HubunganWali::KERABAT, HubunganWali::NONKERABAT, HubunganWali::SAUDARA]))
                                                ->required(fn(Get $get) => ($get('wali_tinggal_luar_negeri') == false)),
                                        ])->columns(2),
                                ])->columns(2),
                        ]),
                ]),
        ];
    }

}
