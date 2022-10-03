<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\{Nationality, NationalityTranslation};

return new class extends Migration
{

	public function up()
	{
		Schema::create(Nationality::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->timestamp('deactivated_at')->nullable();
			$table->SoftDeletes();
			$table->timestamps();
		});

		Schema::create(NationalityTranslation::getTableName(), function(Blueprint $table) {
            $table->id();
			$table->string('locale')->index();
			$table->string('name');
			$table->foreignId('nationality_id')->constrained(Nationality::getTableName())->cascadeOnDelete();
			$table->unique(['nationality_id', 'locale']);
		});
	}

	public function down()
	{
		Schema::dropIfExists(NationalityTranslation::getTableName());
		Schema::dropIfExists(Nationality::getTableName());
	}
};
