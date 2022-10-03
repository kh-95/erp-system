<?php

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Salary;
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
        Schema::create(Salary::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->float('base_salary')->default(0);
            $table->float('gross_salary')->default(0);
            $table->float('net_salary')->default(0);
            $table->date('month')->nullable();
            $table->boolean('is_signed')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->float('deduction_percentage')->default(0);
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();

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
        Schema::dropIfExists(Salary::getTableName());
    }
};
