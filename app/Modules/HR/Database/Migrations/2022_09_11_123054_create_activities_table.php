<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\{Management,Employee};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name',150);
            $table->bigInteger('main_program_id');
            $table->bigInteger('sup_program_id');
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->dateTime('date_from');
            $table->dateTime('date_to');
            $table->text('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
};
