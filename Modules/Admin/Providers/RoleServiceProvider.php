<?php

namespace Modules\Admin\Providers;

use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Entities\Role;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $roles = Role::with('permissions')->get();

            // Prepare an associative array to store permissions and their associated role IDs
            $permissions = [];
            foreach ($roles as $role) {
                foreach ($role->permissions as $permission) {
                    $permissions[$permission->name][] = $role->id;
                }
            }

            // Define Gates based on user roles and their associated permissions
            foreach ($permissions as $permissionName => $roleIds) {
                Gate::define($permissionName, function ($admin) use ($roleIds) {

                    // Check if the user's role ID is in the list of required role IDs
                    return in_array($admin->role->id, $roleIds);
                });
            }

            // Super Admin has all permissions
            Gate::before(function ($admin) {
                if ($admin->role && $admin->role->name === 'super admin') {
                    return true;
                }
            });
        } catch (Exception $e) {
            Log::error($e->getMessage(), (array) $e);
        }
    }
}
