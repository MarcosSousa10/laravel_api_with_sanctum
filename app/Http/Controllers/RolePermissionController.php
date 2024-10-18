<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{

    public function assignRole(Request $request, $userId)
    {
        $request->validate([
            'role' => 'required|string',
            'permission' => 'required|string',
        ]);

        $user = User::findOrFail($userId);
        $roleName = $request->input('role');
        $permissionName = $request->input('permission'); 
        
        if (!Role::where('name', $roleName)->exists()) {
            $role = Role::create(['name' => $roleName]);
        } else {
            $role = Role::findByName($roleName);
        }

        if (!$user->hasRole($role)) {
            $user->assignRole($role);

            if (!Permission::where('name', $permissionName)->exists()) {
                $permission = Permission::create(['name' => $permissionName]);
            } else {
                $permission = Permission::findByName($permissionName);
            }

            if (!$user->hasPermissionTo($permission)) {
                $user->givePermissionTo($permission);
            }

            return response()->json(['message' => 'Role and permission assigned successfully.']);
        }

        return response()->json(['message' => 'User already has this role.'], 400);
    }
    public function getUserPermissions($userId)
    {
        $user = User::findOrFail($userId);

        // Obtém os papéis do usuário
        $roles = $user->getRoleNames();

        // Obtém as permissões do usuário
        $permissions = $user->getAllPermissions()->pluck('name');

        return response()->json([
            'user_id' => $user->id,
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function removeRole(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $roleName = $request->input('role');
        $permissionName = $request->input('permission');

        $role = Role::findByName($roleName);

        if ($user->hasRole($role)) {
            $user->removeRole($role);

            foreach ($role->permissions as $permission) {
                if ($user->hasPermissionTo($permission)) {
                    $user->revokePermissionTo($permission);
                }
            }

            if ($permissionName) {
                $permission = Permission::findByName($permissionName);
                if ($user->hasPermissionTo($permission)) {
                    $user->revokePermissionTo($permission);
                }
            }

            return response()->json(['message' => 'Role and permissions removed successfully.']);
        }

        return response()->json(['message' => 'User does not have this role.'], 400);
    }





    public function assignPermission(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $permission = Permission::findByName($request->input('permission'));

        if (!$user->hasPermissionTo($permission)) {
            $user->givePermissionTo($permission);
            return response()->json(['message' => 'Permission assigned successfully.']);
        }

        return response()->json(['message' => 'User already has this permission.'], 400);
    }

    // Remove uma permissão do usuário
    public function removePermission(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $permission = Permission::findByName($request->input('permission'));

        if ($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);
            return response()->json(['message' => 'Permission removed successfully.']);
        }

        return response()->json(['message' => 'User does not have this permission.'], 400);
    }
}
