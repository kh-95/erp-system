<?php

use App\Modules\HR\Entities\Management;
use App\Modules\Reception\Entities\Report;
use App\Modules\Reception\Entities\ReportTranslation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration {

	public function up()
	{
		Schema::create(Report::getTableName(), function(Blueprint $table) {
			$table->id();
            $table->foreignId('management_id')->nullable()->constrained(Management::getTableName())->nullOnDelete();
			$table->enum('status', array('new', 'underway', 'finished', 'canceled'))->default('new');
			$table->datetime('date');
			$table->timestamps();
			$table->softDeletes();
		});

        Schema::create(ReportTranslation::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->string('locale')->index();
            $table->string('title', 150);
            $table->text('description', 500)->nullable();
            $table->unique(['report_id', 'locale']);
            $table->foreignId('report_id')->constrained(Report::getTableName())->cascadeOnDelete();
            $table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
        Schema::drop(ReportTranslation::getTableName());
		Schema::drop(Report::getTableName());
	}
}
