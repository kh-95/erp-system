<?php

use App\Modules\HR\Entities\Employee;
use Illuminate\Support\Facades\Schema;
use App\Modules\HR\Entities\Management;
use Illuminate\Database\Schema\Blueprint;
use App\Modules\HR\Entities\TrainingCourse;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\TrainingCourseTranslation;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TrainingCourse::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->string('attachments')->nullable();
            $table->date('from_date');
            $table->date('to_date');
            $table->date('actual_from_date');
            $table->date('actual_to_date');
            $table->string('number');
            $table->string('expected_fees');
            $table->timestamps();
        });

        Schema::create(TrainingCourseTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('course_name');
            $table->text('notes');
            $table->text('rejection_cause');
            $table->string('organization_type');
            $table->string('organization_name');
            $table->string('status');
            $table->string('actual_start_status');
            $table->foreignId('training_course_id')->constrained(TrainingCourse::getTableName())->cascadeOnDelete();
            $table->string('locale');
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
        Schema::dropIfExists(TrainingCourseTranslation::getTableName());
        Schema::dropIfExists(TrainingCourse::getTableName());
    }
};
