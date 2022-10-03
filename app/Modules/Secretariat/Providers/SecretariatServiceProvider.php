<?php

namespace App\Modules\Secretariat\Providers;

use App\Modules\Secretariat\Http\Repositories\MeetingRooms\MeetingRoomRepository;
use App\Modules\Secretariat\Http\Repositories\MeetingRooms\MeetingRoomRepositoryInterface;
use App\Modules\Secretariat\Http\Repositories\Meetings\EmployeeMeetingRepository;
use App\Modules\Secretariat\Http\Repositories\Meetings\EmployeeMeetingRepositoryInterface;
use App\Modules\Secretariat\Http\Repositories\Meetings\MeetingDecisionRepository;
use App\Modules\Secretariat\Http\Repositories\Meetings\MeetingDecisionRepositoryInterface;
use App\Modules\Secretariat\Http\Repositories\Meetings\MeetingDiscussionPointRepository;
use App\Modules\Secretariat\Http\Repositories\Meetings\MeetingDiscussionPointRepositoryInterface;
use App\Modules\Secretariat\Http\Repositories\Meetings\MeetingRepository;
use App\Modules\Secretariat\Http\Repositories\Meetings\MeetingRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use App\Modules\Secretariat\Http\Repositories\Appointment\AppointmentRepository;
use App\Modules\Secretariat\Http\Repositories\Appointment\AppointmentRepositoryInterface;

use App\Modules\Secretariat\Http\Repositories\Message\MessageRepository;
use App\Modules\Secretariat\Http\Repositories\Message\MessageRepositoryInterface;

class SecretariatServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Secretariat';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'secretariat';

    private function registerRepositories()
    {
        $this->app->bind(MeetingRoomRepositoryInterface::class, MeetingRoomRepository::class);
        $this->app->bind(MeetingRepositoryInterface::class, MeetingRepository::class);
        $this->app->bind(MeetingDecisionRepositoryInterface::class, MeetingDecisionRepository::class);
        $this->app->bind(MeetingDiscussionPointRepositoryInterface::class, MeetingDiscussionPointRepository::class);
        $this->app->bind(EmployeeMeetingRepositoryInterface::class, EmployeeMeetingRepository::class);
        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);

        $this->app->bind(MessageRepositoryInterface::class, MessageRepository::class);


    }

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
        $this->registerRepositories();
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
