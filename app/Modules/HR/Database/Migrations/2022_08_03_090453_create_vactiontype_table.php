<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Modules\HR\Entities\{VacationType, VacationTypeTranslation};

class CreateVactiontypeTable extends Migration {

	public function up()
	{
		Schema::create(VacationType::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->integer('number_days');
			$table->timestamp('deactivated_at')->nullable();
			$table->SoftDeletes();
			$table->timestamps();
		});

		Schema::create(VacationTypeTranslation::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->string('locale')->index();
			$table->string('name');
			$table->foreignId('vacation_type_id')->constrained(VacationType::getTableName())->cascadeOnDelete();
		});
	}

	public function down()
	{
		Schema::drop(VacationTypeTranslation::getTableName());
		Schema::drop(VacationType::getTableName());
	}
}
