<?php

namespace Database\Seeders;

use App\Enums\RoleUser;
use App\Enums\RoleUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = array_column(RoleUser::cases(), 'value');
        $roles = array_merge($roles, array_column(RoleUser::cases(), 'value'));

        foreach ($roles as $key => $role) {
            $roleCreated = (new (\BezhanSalleh\FilamentShield\Resources\RoleResource::getModel()))->create(
                [
                    'name' => $role,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
