<?php

namespace App\Policies;


use App\Models\Role;
use App\Models\User;


class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Quản trị viên')&& $user->hasRole('Quản trị viên');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
    {
        //
        return $user->hasPermissionTo('Xem vai trò')&& $user->hasRole('Quản trị viên');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasPermissionTo('Tạo vai trò')&& $user->hasRole('Quản trị viên');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): bool
    {
        //
        return $user->hasPermissionTo('Sửa vai trò')&& $user->hasRole('Quản trị viên');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        //
        return $user->hasPermissionTo('Xóa vai trò')&& $user->hasRole('Quản trị viên');
    }

}
