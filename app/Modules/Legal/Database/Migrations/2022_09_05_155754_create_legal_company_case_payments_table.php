<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Legal\Entities\CompanyCasePayment;
use App\Modules\Legal\Entities\CompanyCase;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CompanyCasePayment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('paid_amount');
            $table->string('remaining_amount');
            $table->date('payment_date_from');
            $table->date('payment_date_to');
            $table->foreignId('company_case_id')->constrained(CompanyCase::getTableName())->cascadeOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists(CompanyCasePayment::getTableName());
    }
};
