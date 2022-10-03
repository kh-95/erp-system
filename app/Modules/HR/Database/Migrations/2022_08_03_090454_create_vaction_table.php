<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Modules\HR\Entities\{Vacation, VacationTranslation,Employee,VacationType,VacationAttachment};

class CreateVactionTable extends Migration {

	public function up()
	{
		Schema::create(Vacation::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->foreignId('vacation_employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
			$table->foreignId('vacation_type_id')->constrained(VacationType::getTableName())->cascadeOnDelete();
            $table->date('vacation_from_date');
			$table->date('vacation_to_date');
			$table->integer('number_days');
			$table->foreignId('alter_employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
			$table->timestamp('deactivated_at')->nullable();
			$table->SoftDeletes();
			$table->timestamps();
		});

		Schema::create(VacationTranslation::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->string('locale')->index();
			$table->string('notes');
			$table->foreignId('vacation_id')->constrained(Vacation::getTableName())->cascadeOnDelete();
		});

		Schema::create(VacationAttachment::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->string('attach');
			$table->foreignId('vacation_id')->constrained(Vacation::getTableName())->cascadeOnDelete();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop(VacationTranslation::getTableName());
		Schema::drop(Vacation::getTableName());
	}
}
