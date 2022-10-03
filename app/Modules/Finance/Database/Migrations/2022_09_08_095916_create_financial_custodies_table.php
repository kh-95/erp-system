<?php

use App\Modules\Finance\Entities\FinancialCustody;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
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
        Schema::create(FinancialCustody::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('bill_number');
            $table->string('tax_number');
            $table->string('supplier_name');
            $table->double('total');
            $table->double('tax');
            $table->double('net');
            $table->date('date');
            $table->foreignId('cost_center_id')->constrained(Management::getTableName())->cascadeOnDelete();
            $table->string('allowance_type');
            $table->string('supply_employee_name');
            $table->text('notes')->nullable();
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->string('attachments')->nullable();
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
        Schema::dropIfExists('financial_custodies');
    }
};
