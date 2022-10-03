<?php

namespace App\Modules\Legal\Providers;

use App\Modules\Legal\Http\Repositories\Agenecy\AgenecyRepositoryInterface;
use App\Modules\Legal\Http\Repositories\Investigation\InvestigationRepository;
use Illuminate\Support\ServiceProvider;
use App\Modules\Legal\Http\Repositories\Draft\DraftRepository;
use App\Modules\Legal\Http\Repositories\Agenecy\AgenecyRepository;
use App\Modules\Legal\Http\Repositories\Draft\DraftRepositoryInterface;
use App\Modules\Legal\Http\Repositories\StaticText\StaticTextRepository;
use App\Modules\Legal\Http\Repositories\AgenecyTerm\AgenecyTermRepository;
use App\Modules\Legal\Http\Repositories\AgenecyTerm\AgenecyTermRepositoryInterface;
use App\Modules\Legal\Http\Repositories\StaticText\StaticTextRepositoryInterface;
use App\Modules\Legal\Http\Repositories\AgenecyType\AgenecyTypeRepository;
use App\Modules\Legal\Http\Repositories\AgenecyType\AgenecyTypeRepositoryInterface;

use App\Modules\Legal\Http\Repositories\CaseAgainestCompanyRepository;
use App\Modules\Legal\Http\Repositories\CaseAgainestCompanyRepositoryInterface;
use App\Modules\Legal\Http\Repositories\CompanyCase\CompanyCaseRepository;
use App\Modules\Legal\Http\Repositories\CompanyCase\CompanyCaseRepositoryInterface;
use App\Modules\Legal\Http\Repositories\OrderModel\OrderModelRepository;
use App\Modules\Legal\Http\Repositories\OrderModel\OrderModelRepositoryInterface;
use App\Modules\Legal\Http\Repositories\Consult\ConsultRepository;
use App\Modules\Legal\Http\Repositories\Consult\ConsultRepositoryInterface;
use App\Modules\Legal\Http\Repositories\Investigation\InvestigationRepositoryInterface;
use App\Modules\Legal\Http\Repositories\JudicialDepartment\JudicialDepartmentRepository;
use App\Modules\Legal\Http\Repositories\JudicialDepartment\JudicialDepartmentRepositoryInterface;
use  App\Modules\Legal\Http\Repositories\OrderModel\ConsultResponseRepositoryInterface;
use  App\Modules\Legal\Http\Repositories\OrderModel\ConsultResponseRepository;
class LegalServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Legal';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'legal';

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

        $this->app->bind(AgenecyRepositoryInterface::class, AgenecyRepository::class);
        $this->app->bind(CompanyCaseRepositoryInterface::class, CompanyCaseRepository::class);
        $this->app->bind(InvestigationRepositoryInterface::class, InvestigationRepository::class);
        $this->app->bind(DraftRepositoryInterface::class, DraftRepository::class);
        $this->app->bind(OrderModelRepositoryInterface::class, OrderModelRepository::class);
        $this->app->bind(AgenecyTypeRepositoryInterface::class, AgenecyTypeRepository::class);
        $this->app->bind(StaticTextRepositoryInterface::class, StaticTextRepository::class);
        $this->app->bind(AgenecyTermRepositoryInterface::class, AgenecyTermRepository::class);
        $this->app->bind(ConsultRepositoryInterface::class, ConsultRepository::class);
        $this->app->bind(JudicialDepartmentRepositoryInterface::class, JudicialDepartmentRepository::class);
        $this->app->bind(CaseAgainestCompanyRepositoryInterface::class, CaseAgainestCompanyRepository::class);
        $this->app->bind(ConsultResponseRepositoryInterface::class, ConsultResponseRepository::class);


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
