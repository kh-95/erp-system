<?php

use App\Modules\HR\Entities\Employee;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Reception\Entities\Visit;
use App\Modules\Reception\Entities\EmployeeVisit;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(EmployeeVisit::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->foreignId('visit_id')->constrained(Visit::getTableName())->cascadeOnDelete();
            $table->unique(['employee_id', 'visit_id']);
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
        Schema::dropIfExists('employee_visit');
    }
};
