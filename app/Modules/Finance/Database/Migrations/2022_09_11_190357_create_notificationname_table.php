<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Modules\Finance\Entities\{NotificationName, NotificationNameTranslation};

return new class extends Migration
{
  
	public function up()
	{
		Schema::create(NotificationName::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->timestamp('deactivated_at')->nullable();
			$table->SoftDeletes();
			$table->timestamps();
		});

		Schema::create(NotificationNameTranslation::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->string('locale')->index();
			$table->string('name');
			$table->string('notes');
			$table->foreignId('notification_name_id')->constrained(NotificationName::getTableName())->cascadeOnDelete();
		});

	}

	public function down()
	{
		Schema::drop(NotificationNameTranslation::getTableName());
		Schema::drop(NotificationName::getTableName());
	}
};