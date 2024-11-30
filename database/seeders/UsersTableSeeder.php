<?php

namespace Database\Seeders;

use App\Models\Operator;
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
            'username' => 'superadmin',
            'email' => 'superadmin@tcm-walibarokah.org',
            'nomor_telepon' => '0855555555',
            'email_verified_at' => now(),
            'password' => Hash::make('superadmin'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Artisan::call('shield:super-admin', ['--user' => $sid]);
    }
}

