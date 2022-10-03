<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Modules\Finance\Entities\{ExpenseType, ExpenseTypeTranslation};

return new class extends Migration
{
  
	public function up()
	{
		Schema::create(ExpenseType::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->timestamp('deactivated_at')->nullable();
			$table->SoftDeletes();
			$table->timestamps();
		});

		Schema::create(ExpenseTypeTranslation::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->string('locale')->index();
			$table->string('name');
			$table->string('notes');
			$table->foreignId('expense_type_id')->constrained(ExpenseType::getTableName())->cascadeOnDelete();
		});

	}

	public function down()
	{
		Schema::drop(ExpenseTypeTranslation::getTableName());
		Schema::drop(ExpenseType::getTableName());
	}
};