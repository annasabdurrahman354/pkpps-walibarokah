<?php

use App\Models\JurnalKelas;
use App\Models\MateriSurat;
use Illuminate\Support\Str;

if(! function_exists('getMediaFilename')) {
    function getMediaFilename($model, $media){
        switch($media){
            case 'guru_foto':
                return 'guru_foto' . '_' . Str::slug($model->nama). '_' . $media->id . '.' . $media->extension;
            case 'operator_foto':
                return 'operator_foto' . '_' . Str::slug($model->nama). '_' . $media->id . '.' . $media->extension;
            case 'peserta_kediri_foto_identitas':
                return 'peserta_kediri_foto_identitas' . '_' . Str::slug($model->nama). '_' . $media->id . '.' . $media->extension;
            case 'peserta_kediri_foto_cocard':
                return 'peserta_kediri_foto_cocard' . '_' . Str::slug($model->nama). '_' . $media->id . '.' . $media->extension;
            case 'peserta_kertosono_foto_ijazah':
                return 'peserta_kertosono_foto_ijazah' . '_' . Str::slug($model->nama). '_' . $media->id . '.' . $media->extension;
            default:
                return Str::slug($media->file_name) . '_' . $media->id . '.' . $media->extension;
        }
    }
}


if(!function_exists('isSuperAdmin')) {
    function isSuperAdmin() {
        return auth()->user()->hasRole(\App\Enums\RoleUser::SUPER_ADMIN);
    }
}

if(!function_exists('isAdminKediri')) {
    function isAdminKediri() {
        return auth()->user()->hasRole(\App\Enums\RoleUser::ADMIN_KEDIRI);
    }
}

if(!function_exists('isAdminKertosono')) {
    function isAdminKertosono() {
        return auth()->user()->hasRole(\App\Enums\RoleUser::ADMIN_KERTOSONO);
    }
}

if(!function_exists('isOperatorPonpes')) {
    function isOperatorPonpes() {
        return auth()->user()->hasRole(\App\Enums\RoleUser::OPERATOR_PONPES);
    }
}

if(!function_exists('isGuruKediri')) {
    function isGuruKediri() {
        return auth()->user()->hasRole(\App\Enums\RoleUser::GURU_KEDIRI);
    }
}

if(!function_exists('isGuruKertosono')) {
    function isGuruKertosono() {
        return auth()->user()->hasRole(\App\Enums\RoleUser::GURU_KERTOSONO);
    }
}

if(!function_exists('isPembina')) {
    function isPembina() {
        return auth()->user()->hasRole(\App\Enums\RoleUser::PEMBINA);
    }
}

if(!function_exists('isKompa')) {
    function isKompa() {
        return auth()->user()->hasRole(\App\Enums\RoleUser::KOMPA);
    }
}

if(!function_exists('cant')) {
    function cant($abilities) {
        return !auth()->user()->can($abilities);
    }
}

if(!function_exists('can')) {
    function can($abilities) {
        if (isSuperAdmin()){
            return true;
        }
        else return auth()->user()->can($abilities);
    }
}

if(!function_exists('getProgramStudiList')) {
    function getProgramStudiList(){
        return [
            "Administrasi Publik",
            "Agribisnis",
            "Agronomi",
            "Agroteknologi",
            "Akuntansi",
            "Arsitektur",
            "Bahasa Inggris",
            "Bahasa Mandarin",
            "Bahasa Mandarin dan Kebudayaan Tiongkok",
            "Bimbingan dan Konseling",
            "Biologi",
            "Biosain",
            "Bisnis Digital",
            "Budi Daya Ternak",
            "Demografi dan Pencatatan Sipil",
            "Desain Interior",
            "Desain Komunikasi Visual",
            "Ekonomi Pembangunan",
            "Ekonomi dan Studi Pembangunan",
            "Farmasi",
            "Fisika",
            "Hubungan Internasional",
            "Ilmu Administrasi Negara",
            "Ilmu Ekonomi",
            "Ilmu Fisika",
            "Ilmu Gizi",
            "Ilmu Hukum",
            "Ilmu Kedokteran",
            "Ilmu Keolahragaan",
            "Ilmu Kesehatan Masyarakat",
            "Ilmu Komunikasi",
            "Ilmu Lingkungan",
            "Ilmu Linguistik",
            "Ilmu Pendidikan",
            "Ilmu Pertanian",
            "Ilmu Sejarah",
            "Ilmu Tanah",
            "Ilmu Teknik Mesin",
            "Ilmu Teknik Sipil",
            "Ilmu Teknologi Pangan",
            "Informatika",
            "Kajian Budaya",
            "Kebidanan",
            "Kebidanan Terapan",
            "Kedokteran",
            "Kenotariatan",
            "Keperawatan Anestesiologi",
            "Keselamatan dan Kesehatan Kerja",
            "Keuangan dan Perbankan",
            "Kimia",
            "Komunikasi Terapan",
            "Kriya Seni",
            "Linguistik",
            "Manajemen",
            "Manajemen Administrasi",
            "Manajemen Bisnis",
            "Manajemen Pemasaran",
            "Manajemen Perdagangan",
            "Matematika",
            "Pendidikan Administrasi Perkantoran",
            "Pendidikan Akuntansi",
            "Pendidikan Bahasa dan Sastra Indonesia",
            "Pendidikan Bahasa Indonesia",
            "Pendidikan Bahasa Inggris",
            "Pendidikan Bahasa Jawa",
            "Pendidikan Bahasa dan Sastra Daerah",
            "Pendidikan Biologi",
            "Pendidikan Ekonomi",
            "Pendidikan Fisika",
            "Pendidikan Geografi",
            "Pendidikan Guru Pendidikan Anak Usia Dini",
            "Pendidikan Guru Sekolah Dasar",
            "Pendidikan Guru Sekolah Dasar (Kampus Kabupaten Kebumen)",
            "Pendidikan Guru Vokasi",
            "Pendidikan Ilmu Pengetahuan Alam",
            "Pendidikan Jasmani, Kesehatan dan Rekreasi",
            "Pendidikan Kepelatihan Olahraga",
            "Pendidikan Kimia",
            "Pendidikan Luar Biasa",
            "Pendidikan Matematika",
            "Pendidikan Pancasila dan Kewarganegaraan",
            "Pendidikan Pancasila dan Kewarganegaraan",
            "Pendidikan Profesi Bidan",
            "Pendidikan Profesi Guru",
            "Pendidikan Profesi Guru SD",
            "Pendidikan Sains",
            "Pendidikan Sejarah",
            "Pendidikan Seni",
            "Pendidikan Seni Rupa",
            "Pendidikan Sosiologi Antropologi",
            "Pendidikan Teknik Bangunan",
            "Pendidikan Teknik Informatika & Komputer",
            "Pendidikan Teknik Mesin",
            "Pengelolaan Hutan",
            "Penyuluhan Pembangunan",
            "Penyuluhan Pembangunan/Pemberdayaan Masyarakat",
            "Penyuluhan dan Komunikasi Pertanian",
            "Perencanaan Wilayah dan Kota",
            "Perpajakan",
            "Perpustakaan",
            "Peternakan",
            "Profesi Apoteker",
            "Profesi Dokter",
            "Program Profesi Insinyur",
            "Psikologi",
            "Sains Data",
            "Sastra Arab",
            "Sastra Daerah",
            "Sastra Indonesia",
            "Sastra Inggris",
            "Seni Rupa",
            "Seni Rupa Murni",
            "Sosiologi",
            "Statistika",
            "Teknik Elektro",
            "Teknik Industri",
            "Teknik Informatika",
            "Teknik Kimia",
            "Teknik Mesin",
            "Teknik Sipil",
            "Teknologi Hasil Pertanian",
            "Teknologi Pendidikan",
            "Usaha Perjalanan Wisata"
        ];
    }
}
