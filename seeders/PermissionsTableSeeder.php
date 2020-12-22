<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('permissions')->delete();
        DB::table('roles')->delete();
        DB::table('roles_permissions')->delete();

        $administratorId = DB::table('roles')->insertGetId(['title' => 'Developer']);

        $permissions = [
            ['permission' => 'admin.structure.*', 'title' => 'Content'],
            ['permission' => 'admin.gallery.*', 'title' => 'Gallery'],
            ['permission' => 'admin.types.*', 'title' => 'Types'],
            ['permission' => 'admin.administrators.*', 'title' => 'Administrators'],
            ['permission' => 'admin.translations.*', 'title' => 'Translations'],
            ['permission' => 'admin.permissions.*', 'title' => 'Permissions'],
            ['permission' => 'admin.roles.*', 'title' => 'Roles'],
            ['permission' => 'admin.password.*', 'title' => 'Password'],
            ['permission' => 'admin.login.*', 'title' => 'Login'],
            ['permission' => 'admin.logout', 'title' => 'Logout'],
            ['permission' => 'admin.login', 'title' => 'Login index'],
        ];

        foreach ($permissions as $permission) {
            $permissionId = DB::table('permissions')->insertGetId($permission);

            DB::table('roles_permissions')->insert([
                'role_id' => $administratorId,
                'permission_id' => $permissionId,
                'type' => 'ALLOW'
            ]);
        }
    }
}
