<?php

namespace App\Modules\HR\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use App\Modules\HR\Http\Repositories\Job\JobRepository;
use App\Modules\HR\Http\Repositories\Item\ItemRepository;

// use App\Modules\HR\Http\Repositories\Employee\BlackListEmployeeRepository;
// use App\Modules\HR\Http\Repositories\Employee\BlackListEmployeeRepositoryInterface;
use App\Modules\HR\Http\Repositories\Bonus\BonusesRepository;
use App\Modules\HR\Http\Repositories\Deduct\DeductRepository;

use App\Modules\HR\Http\Repositories\Salary\SalaryRepository;
use App\Modules\HR\Http\Repositories\Employee\CustodyRepository;

//use App\Modules\HR\Http\Repositories\Bonus\BonusesRepository;

//use App\Modules\HR\Http\Repositories\Employee\BonusesRepository;
//use App\Modules\HR\Http\Repositories\Employee\BonusesRepositoryInterface;
use App\Modules\HR\Http\Repositories\Job\JobRepositoryInterface;
use App\Modules\HR\Http\Repositories\Employee\EmployeeRepository;

use App\Modules\HR\Http\Repositories\Vacation\VacationRepository;
use App\Modules\HR\Http\Repositories\Employee\BlackListRepository;
use App\Modules\HR\Http\Repositories\Item\ItemRepositoryInterface;
use App\Modules\HR\Http\Repositories\Interview\InterviewRepository;
use App\Modules\HR\Http\Repositories\Management\ManagementRepository;
use App\Modules\HR\Http\Repositories\Bonus\BonusesRepositoryInterface;
use App\Modules\HR\Http\Repositories\Salary\SalaryRepositoryInterface;
use  App\Modules\HR\Http\Repositories\Deduct\DeductRepositoryInterface;
use App\Modules\HR\Http\Repositories\Nationality\NationalityRepository;
use App\Modules\HR\Http\Repositories\Resignation\ResignationRepository;
use App\Modules\HR\Http\Repositories\Contracts\ContractClauseRepository;
use App\Modules\HR\Http\Repositories\Employee\CustodyRepositoryInterface;
use App\Modules\HR\Http\Repositories\HoldHarmless\HoldHarmlessRepository;
use App\Modules\HR\Http\Repositories\VacationType\VacationTypeRepository;
use App\Modules\HR\Http\Repositories\Employee\EmployeeRepositoryInterface;
use App\Modules\HR\Http\Repositories\Vacation\VacationRepositoryInterface;
use App\Modules\HR\Http\Repositories\Employee\AttachmentEmployeeRepository;
use App\Modules\HR\Http\Repositories\Employee\BlackListRepositoryInterface;
use App\Modules\HR\Http\Repositories\Interview\InterviewRepositoryInterface;
use App\Modules\HR\Http\Repositories\ServiceRequest\ServiceRequestRepository;
use App\Modules\HR\Http\Repositories\TrainingCourse\TrainingCourseRepository;
use App\Modules\HR\Http\Repositories\Management\ManagementRepositoryInterface;
use App\Modules\HR\Http\Repositories\Attendance\AttendanceFingerprintRepository;
use App\Modules\HR\Http\Repositories\Nationality\NationalityRepositoryInterface;
use App\Modules\HR\Http\Repositories\Resignation\ResignationRepositoryInterface;
use App\Modules\HR\Http\Repositories\Contracts\ContractClauseRepositoryInterface;
use App\Modules\HR\Http\Repositories\HoldHarmless\HoldHarmlessRepositoryInterface;
use App\Modules\HR\Http\Repositories\Interview\Applications\ApplicationRepository;

use App\Modules\HR\Http\Repositories\VacationType\VacationTypeRepositoryInterface;
use App\Modules\HR\Http\Repositories\PermissionRequest\PermissionRequestRepository;
use App\Modules\HR\Http\Repositories\Employee\AttachmentEmployeeRepositoryInterface;
use App\Modules\HR\Http\Repositories\EmployeeEvaluation\EmployeeEvaluationRepository;

use App\Modules\HR\Http\Repositories\ServiceRequest\ServiceRequestRepositoryInterface;
use App\Modules\HR\Http\Repositories\TrainingCourse\TrainingCourseReporitoryInterface;

use App\Modules\HR\Http\Repositories\Attendance\AttendanceFingerprintRepositoryInterface;
use App\Modules\HR\Http\Repositories\Interview\Applications\ApplicationRepositoryInterface;
use App\Modules\HR\Http\Repositories\PermissionRequest\PermissionRequestRepositoryInterface;
use App\Modules\HR\Http\Repositories\EmployeeEvaluation\EmployeeEvaluationRepositoryInterface;

use App\Modules\HR\Http\Repositories\activity\{ActivityRepository,ActivityRepositoryInterface};

use App\Modules\HR\Http\Repositories\ServiceRequest\{ServiceResponseRepository,ServiceResponseRepositoryInterface};

class HRServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'HR';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'hr';

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
        $this->app->bind(NationalityRepositoryInterface::class, NationalityRepository::class);
        $this->app->bind(ManagementRepositoryInterface::class, ManagementRepository::class);
        $this->app->bind(TrainingCourseReporitoryInterface::class, TrainingCourseRepository::class);
        $this->app->bind(JobRepositoryInterface::class, JobRepository::class);
//        $this->app->bind(BonusesRepositoryInterface::class, BonusesRepository::class);
        // $this->app->bind(BlackListEmployeeRepositoryInterface::class, BlackListEmployeeRepository::class);
        $this->app->bind(CustodyRepositoryInterface::class, CustodyRepository::class);
        $this->app->bind(AttachmentEmployeeRepositoryInterface::class, AttachmentEmployeeRepository::class);

        $this->app->bind(SalaryRepositoryInterface::class, SalaryRepository::class);

        $this->app->bind(DeductRepositoryInterface::class, DeductRepository::class);

        $this->app->bind(AttendanceFingerprintRepositoryInterface::class, AttendanceFingerprintRepository::class);
        $this->app->bind(ServiceRequestRepositoryInterface::class, ServiceRequestRepository::class);
        $this->app->bind(BonusesRepositoryInterface::class, BonusesRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(PermissionRequestRepositoryInterface::class, PermissionRequestRepository::class);
        $this->app->bind(BlackListRepositoryInterface::class, BlackListRepository::class);
        $this->app->bind(EmployeeEvaluationRepositoryInterface::class, EmployeeEvaluationRepository::class);
        $this->app->bind(ItemRepositoryInterface::class, ItemRepository::class);
        $this->app->bind(InterviewRepositoryInterface::class, InterviewRepository::class);
        $this->app->bind(VacationTypeRepositoryInterface::class, VacationTypeRepository::class);
        $this->app->bind(VacationTypeRepositoryInterface::class, VacationTypeRepository::class);
        $this->app->bind(VacationRepositoryInterface::class, VacationRepository::class);
        $this->app->bind(ResignationRepositoryInterface::class, ResignationRepository::class);
        $this->app->bind(HoldHarmlessRepositoryInterface::class, HoldHarmlessRepository::class);
        $this->app->bind(ApplicationRepositoryInterface::class, ApplicationRepository::class);
        $this->app->bind(ContractClauseRepositoryInterface::class, ContractClauseRepository::class);
        $this->app->bind(ActivityRepositoryInterface::class, ActivityRepository::class);
        $this->app->bind(ServiceResponseRepositoryInterface::class, ServiceResponseRepository::class);
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
