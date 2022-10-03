<?php

use App\Modules\HR\Entities\Employee;
use App\Modules\Secretariat\Entities\Appointment;
use App\Modules\Secretariat\Entities\AppointmentTranslation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppointmentsTable extends Migration {

	public function up()
	{
		Schema::create(Appointment::getTableName(), function(Blueprint $table) {
			$table->id();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
			$table->datetime('appointment_date');
            $table->enum('status',Appointment::APPOINTMENT_STATUS)->default('on_progress');
			$table->timestamps();
			$table->softDeletes();
		});

        Schema::create(AppointmentTranslation::getTableName(), function(Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->Text('details',1000)->nullable();
            $table->string('title', 150);
            $table->unique(['appointment_id', 'locale']);
            $table->foreignId('appointment_id')->constrained(Appointment::getTableName())->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
		});
	}

	public function down()
	{
        Schema::dropIfExists(AppointmentTranslation::getTableName());
		Schema::dropIfExists(Appointment::getTableName());
	}
}
