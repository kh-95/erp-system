<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use App\Modules\Legal\Entities\Investigation;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('legal_investigations', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('investigation_number')->unique();
            $table->date('month_one')->nullable();
            $table->date('month_one_hijri')->nullable();
            $table->date('month_two')->nullable();
            $table->date('month_two_hijri')->nullable();
            $table->integer('old_investigation_count')->default(0);
            $table->string('subject')->nullable();
            $table->text('reason')->nullable();
            $table->enum('status',Investigation::INVESTIGATION_STATUS)->default(Investigation::NEW);
            $table->enum('investigation_result',Investigation::INVESTIGATION_RESULT);
            $table->text('notes')->nullable();
            $table->string('asigned_employee');
            // $table->foreignId('asigned_employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists('legal_investigations');
    }
};
