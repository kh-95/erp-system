<?php

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\EmployeeEvaluation;
use App\Modules\HR\Entities\Job;
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
        Schema::create(EmployeeEvaluation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('management_id')->nullable()->constrained(Management::getTableName())->nullOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained(Employee::getTableName())->nullOnDelete();
            $table->foreignId('job_id')->nullable()->constrained(Job::getTableName())->nullOnDelete();
            $table->date('evaluation_date');
            $table->date('started_at');
            $table->date('ended_at');
            $table->enum('recommndation',EmployeeEvaluation::RECOMMENDATION);
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(EmployeeEvaluation::getTableName());
    }
};
