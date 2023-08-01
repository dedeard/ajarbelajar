<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Entities\Role;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'Admin';

    /**
     * @var string
     */
    protected $moduleNameLower = 'admin';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        // Define Gates based on user roles and their associated permissions
        $this->defineGatesForRoles();
    }

    /**
     * Define Gates based on user roles and their associated permissions.
     */
    public function defineGatesForRoles()
    {
        // Retrieve all roles along with their permissions
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
                // Super Admin has all permissions
                if ($admin->role->name === 'Super Admin') {
                    return true;
                }

                // Check if the user's role ID is in the list of required role IDs
                return in_array($admin->role->id, $roleIds);
            });
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower.'.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], ['views', $this->moduleNameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        Blade::anonymousComponentPath($sourcePath.'/components', $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/'.$this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (Config::get('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }

        return $paths;
    }
}
