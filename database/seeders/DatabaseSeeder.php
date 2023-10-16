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
        $user2 = User::factory()->create([
            'name' => 'NGUYEN VAN A',
            'email' => 'manager@admin.com'
        ]);
        $user3 = User::factory()->create([
            'name' => 'NGUYEN VAN C',
            'email' => 'sell@admin.com'
        ]);
        $user4 = User::factory()->create([
            'name' => 'NGUYEN VAN D',
            'email' => 'staff@admin.com'
        ]);
        // Tạo vai trò
        $role1 = Role::create(['name' => 'Quản trị viên']);
        $role2 = Role::create(['name' => 'Quản lý']);
        $role3 = Role::create(['name' => 'Bán hàng']);
        $role4 = Role::create(['name' => 'Nhân viên']);
        // phân quyền cho tài khoản
        $user1->assignRole($role1);
        $user2->assignRole($role2);
        $user3->assignRole($role3);
        $user4->assignRole($role4);
        // Tạo quyền hạn
        // Người dùng
        $permission1 = Permission::create(['name' => 'Xem người dùng']);
        $permission2 = Permission::create(['name' => 'Xóa người dùng']);
        $permission3 = Permission::create(['name' => 'Sửa người dùng']);
        $permission4 = Permission::create(['name' => 'Tạo người dùng']);
        // Vai trò
        $permission5 = Permission::create(['name' => 'Xem vai trò']);
        $permission6 = Permission::create(['name' => 'Xóa vai trò']);
        $permission7 = Permission::create(['name' => 'Sửa vai trò']);
        $permission8 = Permission::create(['name' => 'Tạo vai trò']);
        // Quyền hạn
        $permission9 = Permission::create(['name' => 'Xem quyền hạn']);
        $permission10 = Permission::create(['name' => 'Xóa quyền hạn']);
        $permission11 = Permission::create(['name' => 'Sửa quyền hạn']);
        $permission12 = Permission::create(['name' => 'Tạo quyền hạn']);
        // Bài viết
        $permission13 = Permission::create(['name' => 'Xem bài viết']);
        $permission14 = Permission::create(['name' => 'Xóa bài viết']);
        $permission15 = Permission::create(['name' => 'Sửa bài viết']);
        $permission16 = Permission::create(['name' => 'Tạo bài viết']);
        // Danh mục bài viết
        $permission17 = Permission::create(['name' => 'Xem danh mục']);
        $permission18 = Permission::create(['name' => 'Xóa danh mục']);
        $permission19 = Permission::create(['name' => 'Sửa danh mục']);
        $permission20 = Permission::create(['name' => 'Tạo danh mục']);
        // Phân quyền cho vai trò
        $role1->syncPermissions([$permission1, $permission2, $permission3, $permission4,
            $permission5, $permission6,
            $permission7, $permission8, $permission9, $permission10, $permission11, $permission12]);
        $role4->syncPermissions([$permission20, $permission19, $permission18,
            $permission17, $permission16, $permission15, $permission14, $permission13]);
    }
}
