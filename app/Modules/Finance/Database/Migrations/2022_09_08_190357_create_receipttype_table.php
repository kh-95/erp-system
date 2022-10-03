<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Modules\Finance\Entities\{ReceiptType, ReceiptTypeTranslation};

return new class extends Migration
{
  
	public function up()
	{
		Schema::create(ReceiptType::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->timestamp('deactivated_at')->nullable();
			$table->SoftDeletes();
			$table->timestamps();
		});

		Schema::create(ReceiptTypeTranslation::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->string('locale')->index();
			$table->string('name');
			$table->string('notes');
			$table->foreignId('receipt_type_id')->constrained(ReceiptType::getTableName())->cascadeOnDelete();
		});

	}

	public function down()
	{
		Schema::drop(ReceiptTypeTranslation::getTableName());
		Schema::drop(ReceiptType::getTableName());
	}
};