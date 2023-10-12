<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $user1 = User::factory()->create([
            'name' => 'NGUYEN VAN B',
            'email' => 'admin@admin.com'
        ]);
        User::factory()->create([
            'name' => 'NGUYEN VAN A',
            'email' => 'test@gmail.com'
        ]);
        $role = Role::create(['name' => 'Super admin']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);
        Role::create(['name' => 'Staff']);
        $user1->assignRole($role);
        $permission1 = Permission::create(['name' => 'Xem tài khoản']);
        $permission2 = Permission::create(['name' => 'Xóa tài khoản']);
        $permission3 = Permission::create(['name' => 'Sửa tài khoản']);
        $permission4 = Permission::create(['name' => 'Tạo tài khoản']);
        $role->syncPermissions([$permission1, $permission2, $permission3, $permission4]);
    }
}
