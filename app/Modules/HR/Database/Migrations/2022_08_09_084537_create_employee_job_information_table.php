<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Modules\HR\Entities\{EmployeeJobInformation,Job,Employee};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(EmployeeJobInformation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->foreignId('job_id')->constrained(Job::getTableName())->cascadeOnDelete();
            $table->string('employee_number');
            $table->string('contract_type');
            $table->date('receiving_work_date');
            $table->integer('contract_period');
            $table->float('salary',15,2);
            $table->float('other_allowances')->default(0);
            $table->float('salary_percentage')->nullable();
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
        Schema::dropIfExists(EmployeeJobInformation::getTableName());
    }
};
