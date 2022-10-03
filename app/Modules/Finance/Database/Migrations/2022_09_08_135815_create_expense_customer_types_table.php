<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Finance\Entities\{Expenses,ExpenseCustomerType};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ExpenseCustomerType::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id');
            $table->bigInteger('customer_identity');
            $table->bigInteger('phone');
            $table->enum('premium',['waiting', 'late' , 'owed']);
            $table->double('his_money');
            $table->foreignId('expense_id')->constrained(Expenses::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists('expense_customer_types');
    }
};
