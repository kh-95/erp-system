<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CreateAllInModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:all {Entity} {Module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create everything in your module';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $entity = $this->argument('Entity');
        $module = $this->argument('Module');

        $fcEntity = ucfirst($entity);
        $lowerCaseEntity = strtolower($entity);

        Artisan::call("module:make-model $fcEntity " . $module);
        Artisan::call("module:make-migration create_" . strtolower($module) . "_" . Str::plural($lowerCaseEntity) . "_table " . $module);
        Artisan::call("module:make-request $fcEntity" . "Request " . $module);
        Artisan::call("module:make-resource $fcEntity" . "Resource " . $module);
        Artisan::call("module:make-controller $fcEntity" . "Controller " . $module);

        return $this->info("Done Created");
    }
}
