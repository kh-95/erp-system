<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Finance\Entities\Expenses;
use App\Modules\HR\Entities\Management;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Expenses::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->enum('pay_status',['check','bank']);
            $table->enum('customer_type',['cutomer', 'customer_with_service' , 'account']);
            $table->dateTime('date');
            $table->bigInteger('certificate_number');
            $table->double('money');
            $table->bigInteger('from_cash_register');
            $table->bigInteger('to_cash_register');
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
        Schema::dropIfExists('expenses');
    }
};
