<?php

use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\JobTranslation;
use App\Modules\HR\Entities\Management;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Job::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->integer('employees_job_count')->default(1);
            $table->boolean('is_manager')->default(0);
            $table->enum('contract_type', Job::SALARY_TYPES);
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
			$table->timestamp('deactivated_at')->nullable();
			$table->softDeletes();
			$table->timestamps();
        });

        Schema::create(JobTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('job_id')->constrained(Job::getTableName())->cascadeOnDelete();
            $table->unique(['job_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(JobTranslation::getTableName());
        Schema::dropIfExists(Job::getTableName());

    }
};
