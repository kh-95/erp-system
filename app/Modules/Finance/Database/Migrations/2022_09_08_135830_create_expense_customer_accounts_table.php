<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Finance\Entities\{Expenses,ExpenseCustomerAccount};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_customer_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_sympolize');
            $table->bigInteger('iban');
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
        Schema::dropIfExists('expense_customer_accounts');
    }
};
