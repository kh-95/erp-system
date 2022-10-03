<?php

namespace App\Modules\RiskManagement\Providers;

use App\Modules\RiskManagement\Http\Repositories\Bank\BankRepository;
use App\Modules\RiskManagement\Http\Repositories\Bank\BankRepositoryInterface;
use App\Modules\RiskManagement\Http\Repositories\Notification\NotificationRepository;
use App\Modules\RiskManagement\Http\Repositories\Notification\NotificationInterface;
use App\Modules\RiskManagement\Http\Repositories\NotificationVendor\NotificationVendorRepository;
use App\Modules\RiskManagement\Http\Repositories\NotificationVendor\NotificationVendorRepositoryInterface;
use App\Modules\RiskManagement\Http\Repositories\Transaction\TransactionRepositoryInterface;
use App\Modules\RiskManagement\Http\Repositories\Transaction\TransactionRepository;
use App\Modules\RiskManagement\Http\Repositories\V\VendorClassRepositoryInterface;
use App\Modules\RiskManagement\Http\Repositories\Vendor\VendorRepository;
use App\Modules\RiskManagement\Http\Repositories\Vendor\VendorRepositoryInterface;
use App\Modules\RiskManagement\Http\Repositories\VendorClass\VendorClassRepository;
use App\Modules\RiskManagement\Http\Repositories\VendorClass\VendorClassRepositoryInterface as VendorClassVendorClassRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RiskManagementServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'RiskManagement';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'riskmanagement';

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

        $this->app->bind(NotificationInterface::class, NotificationRepository::class);
        $this->app->bind(VendorRepositoryInterface::class, VendorRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->bind(BankRepositoryInterface::class, BankRepository::class);

        $this->app->bind(VendorClassVendorClassRepositoryInterface::class, VendorClassRepository::class);

        $this->app->bind(NotificationVendorRepositoryInterface::class,NotificationVendorRepository::class);
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
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'),
            $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
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
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
