<?php

use App\Modules\HR\Entities\Employee;
use App\Modules\Secretariat\Entities\EmployeeMeeting;
use App\Modules\Secretariat\Entities\Meeting;
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
        Schema::create(EmployeeMeeting::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->foreignId('meeting_id')->constrained(Meeting::getTableName())->cascadeOnDelete();
            $table->dateTime('status')->nullable();
            $table->text('rejected_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(EmployeeMeeting::getTableName());
    }
};
