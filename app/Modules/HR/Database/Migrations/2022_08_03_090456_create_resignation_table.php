<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Modules\HR\Entities\{Resignation, ResignationTranslation,Employee, Job, Management, ResignationAttachment,ResignationReason,ResignationReasonTranslation};

class CreateResignationTable extends Migration {

	public function up()
	{
		Schema::create(Resignation::getTableName(), function(Blueprint $table) {
			$table->id();
            $table->foreignId('management_id')->nullable()->constrained(Management::getTableName())->nullOnDelete();
			$table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->foreignId('job_id')->nullable()->constrained(Job::getTableName())->nullOnDelete();
            $table->date('resignation_date');
			$table->timestamp('deactivated_at')->nullable();
			$table->SoftDeletes();
			$table->timestamps();
		});

		Schema::create(ResignationTranslation::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->string('locale')->index();
			$table->string('notes');
			$table->foreignId('resignation_id')->constrained(Resignation::getTableName())->cascadeOnDelete();
		});

		Schema::create(ResignationAttachment::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->string('attach');
			$table->foreignId('resignation_id')->constrained(Resignation::getTableName())->cascadeOnDelete();
			$table->timestamps();
			$table->SoftDeletes();
		});

		Schema::create(ResignationReason::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->foreignId('resignation_id')->constrained(Resignation::getTableName())->cascadeOnDelete();
			$table->timestamps();
			$table->SoftDeletes();
		});

		Schema::create(ResignationReasonTranslation::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->string('locale')->index();
			$table->string('reason');
			$table->foreignId('resignation_reason_id')->constrained(ResignationReason::getTableName())->cascadeOnDelete();
		});

	}

	public function down()
	{
		Schema::drop(ResignationReasonTranslation::getTableName());
		Schema::drop(ResignationReason::getTableName());
		Schema::drop(ResignationAttachment::getTableName());
		Schema::drop(ResignationTranslation::getTableName());
		Schema::drop(Resignation::getTableName());
	}
}
