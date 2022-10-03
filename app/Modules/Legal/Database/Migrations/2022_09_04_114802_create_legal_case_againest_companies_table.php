<?php

use App\Modules\HR\Entities\Employee;
use App\Modules\Legal\Entities\CaseAgainestCompany;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CaseAgainestCompany::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->integer('court_number')->nullable();
            $table->enum('court_type',CaseAgainestCompany::COURTS);
            $table->string('area');
            $table->date('case_filing_date');
            $table->date('case_filing_date_hijri');
            $table->enum('status',CaseAgainestCompany::STATUSES);
            $table->string('case_fee')->nullable();
            $table->text('case_reason')->nullable();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(CaseAgainestCompany::getTableName());
    }
};
