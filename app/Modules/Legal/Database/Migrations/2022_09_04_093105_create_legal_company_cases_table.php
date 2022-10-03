<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Legal\Entities\CompanyCase;
use App\Modules\Legal\Entities\Order;
use App\Modules\HR\Entities\Employee;
use App\Modules\Legal\Entities\JudicialDepartment\JudicialDepartment;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CompanyCase::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('case_number');
            $table->string('order_number');
            $table->foreignId('judicial_department_id')->constrained(JudicialDepartment::getTableName())->cascadeOnDelete();
            $table->date('case_date1');
            $table->date('case_date2');
            $table->string('amount');
            $table->string('cost');
            $table->enum('status', CompanyCase::STATUS);
            $table->enum('reconciliation_status', CompanyCase::RECONCILIATION_STATUS);
            $table->enum('execution_status', CompanyCase::EXECUTION_STATUS);
            $table->string('execution_number');
            $table->string('execution_area_number');
            $table->boolean('decision_34')->default(false);
            $table->boolean('decision_46')->default(false);
            $table->boolean('decision_83')->default(false);
            $table->string('request_number');
            $table->enum('payment', CompanyCase::PAYMENT);
            $table->string('time_out_duration')->nullable();
            $table->date('time_out_date1')->nullable();
            $table->date('time_out_date2')->nullable();
            $table->string('vendor_name');
            $table->string('vendor_identity_number');
            $table->string('vendor_phone');
            $table->string('contract_number');
            $table->string('late_installments')->default(0);
            $table->string('installments_amount')->default(0);
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
        Schema::dropIfExists(CompanyCase::getTableName());
    }
};
