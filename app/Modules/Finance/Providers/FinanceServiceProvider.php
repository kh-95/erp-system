<?php

namespace App\Modules\Finance\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

use App\Modules\Finance\Http\Repositories\AssetRepository;
use App\Modules\Finance\Http\Repositories\AssetRepositoryInterface;

use App\Modules\Finance\Http\Repositories\NotificationRepository;
use App\Modules\Finance\Http\Repositories\NotificationRepositoryInterface;

use App\Modules\Finance\Http\Repositories\CachRegisterRepository;
use App\Modules\Finance\Http\Repositories\CachRegisterRepositoryInterface;

use App\Modules\Finance\Http\Repositories\Receipts\RecieptRepositoryInterface;
use App\Modules\Finance\Http\Repositories\Receipts\RecieptRepository;

use App\Modules\Finance\Http\Repositories\AccountingTree\AccountingTreeRepository;
use App\Modules\Finance\Http\Repositories\AccountingTree\AccountingTreeRepositoryInterface;

use App\Modules\Finance\Http\Repositories\AssetCategory\AssetCategoryRepository;
use App\Modules\Finance\Http\Repositories\AssetCategory\AssetCategoryRepositoryInterface;
use App\Modules\Finance\Http\Repositories\Custody\FinancialCustodyRepository;
use App\Modules\Finance\Http\Repositories\Custody\FinancialCustodyRepositoryInterface;

use App\Modules\Finance\Http\Repositories\ConstraintType\ConstraintTypeRepository;
use App\Modules\Finance\Http\Repositories\ConstraintType\ConstraintTypeRepositoryInterface;
use App\Modules\Finance\Http\Repositories\Expenses\ExpenseRepositoryInterface;
use App\Modules\Finance\Http\Repositories\Expenses\ExpenseRepository;

use App\Modules\Finance\Http\Repositories\ExpenseType\ExpenseTypeRepository;
use App\Modules\Finance\Http\Repositories\ExpenseType\ExpenseTypeRepositoryInterface;

use App\Modules\Finance\Http\Repositories\ReceiptType\ReceiptTypeRepository;
use App\Modules\Finance\Http\Repositories\ReceiptType\ReceiptTypeRepositoryInterface;

use App\Modules\Finance\Http\Repositories\NotificationName\NotificationNameRepository;
use App\Modules\Finance\Http\Repositories\NotificationName\NotificationNameRepositoryInterface;

class FinanceServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Finance';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'finance';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->bind(AssetRepositoryInterface::class, AssetRepository::class);
        $this->app->bind(AccountingTreeRepositoryInterface::class, AccountingTreeRepository::class);
        $this->app->bind(AssetCategoryRepositoryInterface::class, AssetCategoryRepository::class);
        $this->app->bind(ConstraintTypeRepositoryInterface::class, ConstraintTypeRepository::class);
        $this->app->bind(ExpenseTypeRepositoryInterface::class, ExpenseTypeRepository::class);
        $this->app->bind(ReceiptTypeRepositoryInterface::class, ReceiptTypeRepository::class);
        $this->app->bind(NotificationNameRepositoryInterface::class, NotificationNameRepository::class);

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(CachRegisterRepositoryInterface::class, CachRegisterRepository::class);
        $this->app->bind(FinancialCustodyRepositoryInterface::class, FinancialCustodyRepository::class);
        $this->app->bind(RecieptRepositoryInterface::class, RecieptRepository::class);
        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class);
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
