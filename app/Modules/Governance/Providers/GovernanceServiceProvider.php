<?php

namespace App\Modules\Governance\Providers;

use App\Modules\Governance\Http\Repositories\Member\MemberRepository;
use App\Modules\Governance\Http\Repositories\Committee\CommitteeRepository;
use App\Modules\Governance\Http\Repositories\Member\MemberRepositoryInterface;
use App\Modules\Governance\Http\Repositories\Notification\NotificationRepository;
use App\Modules\Governance\Http\Repositories\Committee\CommitteeRepositoryInterface;
use App\Modules\Governance\Http\Repositories\Notification\NotificationRepositoryInterface;
use App\Modules\Governance\Http\Repositories\CandidacyApplication\CandidacyApplicationRepository;
use App\Modules\Governance\Http\Repositories\CandidacyApplication\CandidacyApplicationRepositoryInterface;
use App\Modules\Governance\Http\Repositories\Meeting\MeetingRepository;
use App\Modules\Governance\Http\Repositories\Meeting\MeetingRepositoryInterface;
use App\Modules\Governance\Http\Repositories\Regulation\RegulationRepository;
use App\Modules\Governance\Http\Repositories\Regulation\RegulationRepositoryInterface;
use App\Modules\Governance\Http\Repositories\Succession\SuccessionRepository;
use App\Modules\Governance\Http\Repositories\Succession\SuccessionRepositoryInterface;
use App\Modules\Governance\Http\Repositories\StrategicPlan\StrategicPlanRepository;
use App\Modules\Governance\Http\Repositories\StrategicPlan\StrategicPlanRepositoryInterface;
use App\Modules\Governance\Http\Repositories\MeetingPlace\MeetingPlaceRepository;
use App\Modules\Governance\Http\Repositories\MeetingPlace\MeetingPlaceRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;


class GovernanceServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Governance';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'governance';

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
        $this->app->bind(StrategicPlanRepositoryInterface::class, StrategicPlanRepository::class);
        $this->app->bind(MeetingRepositoryInterface::class, MeetingRepository::class);
        $this->app->bind(MeetingPlaceRepositoryInterface::class, MeetingPlaceRepository::class);
        $this->app->bind(MemberRepositoryInterface::class, MemberRepository::class);
        $this->app->bind(CommitteeRepositoryInterface::class, CommitteeRepository::class);
        $this->app->bind(SuccessionRepositoryInterface::class, SuccessionRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(CandidacyApplicationRepositoryInterface::class, CandidacyApplicationRepository::class);
        $this->app->bind(RegulationRepositoryInterface::class, RegulationRepository::class);
        $this->app->bind(StrategicPlanRepositoryInterface::class, StrategicPlanRepository::class);
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
