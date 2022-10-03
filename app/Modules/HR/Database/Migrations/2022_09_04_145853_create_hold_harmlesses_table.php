<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\HoldHarmless\HoldHarmless;
use App\Modules\HR\Entities\HoldHarmless\HoldHarmlessTranslation;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(HoldHarmless::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            //0 -> don't see request , 1 -> rejected , 2 -> accepted
            $table->enum('dm_response',HoldHarmless::DM_RESPONSE)->default('pending');
            $table->enum('hr_response',HoldHarmless::HR_RESPONSE)->default('pending');
            $table->enum('it_response',HoldHarmless::IT_RESPONSE )->default('pending');
            $table->enum('legal_response',HoldHarmless::lEGAL_RESPONSE )->default('pending');
            $table->enum('finance_response', HoldHarmless::FINANACE_RESPONSE)->default('pending');
            $table->enum('queue', ['begin', 'dm','finance','hr' , 'it', 'legal', 'finished'])->default('hr');
            $table->enum('reason',HoldHarmless::Reason);
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create(HoldHarmlessTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->text('note',500);
            //0 -> don't see request , 1 -> rejected , 2 -> accepted
            $table->string('dm_rejection_reason',150)->nullable();
            $table->string('hr_rejection_reason',150)->nullable();
            $table->string('it_rejection_reason',150)->nullable();
            $table->string('legal_rejection_reason',150)->nullable();
            $table->string('finance_rejection_reason',150)->nullable();
            $table->text('hr_note',500)->nullable();
            $table->text('it_note',500)->nullable();
            $table->text('legal_note',500)->nullable();
            $table->text('finance_note',500)->nullable();

            $table->unique(['hold_harmless_id', 'locale']);
            $table->foreignId('hold_harmless_id')->constrained(HoldHarmless::getTableName())->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hold_harmlesses');
    }
};
