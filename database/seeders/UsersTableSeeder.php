<?php

namespace Database\Seeders;

use App\Enums\JenisKelamin;
use App\Enums\StatusUser;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $sid = Str::ulid();

        DB::table('users')->insert([
            'id' => $sid,
            'nama' => 'Super Admin',
            'nama_panggilan' => 'Super Admin',
            'jenis_kelamin' => JenisKelamin::LAKI_LAKI,
            'kewarganegaraan' => 'wni',
            'unit' => json_encode(['ula', 'wustha', 'ulya']), // Encode the array as JSON
            'status' => StatusUser::AKTIF,
            'email' => 'superadmin@pkpps-walibarokah.org',
            'nomor_telepon' => '0',
            'email_verified_at' => now(),
            'password' => Hash::make('superadmin'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Artisan::call('shield:super-admin', ['--user' => $sid]);
    }
}

