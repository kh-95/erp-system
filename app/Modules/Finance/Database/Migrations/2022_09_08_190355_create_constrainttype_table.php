<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Modules\Finance\Entities\{ConstraintType, ConstraintTypeTranslation};

return new class extends Migration
{
  
	public function up()
	{
		Schema::create(ConstraintType::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->timestamp('deactivated_at')->nullable();
			$table->SoftDeletes();
			$table->timestamps();
		});

		Schema::create(ConstraintTypeTranslation::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->string('locale')->index();
			$table->string('name');
			$table->string('notes');
			$table->foreignId('constraint_type_id')->constrained(ConstraintType::getTableName())->cascadeOnDelete();
		});

	}

	public function down()
	{
		Schema::drop(ConstraintTypeTranslation::getTableName());
		Schema::drop(ConstraintType::getTableName());
	}
};