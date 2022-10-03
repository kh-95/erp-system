<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Finance\Entities\CashRegister;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CashRegister::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tranfer_number');
            $table->dateTime('date');
            $table->double('money');
            $table->bigInteger('from_register');
            $table->bigInteger('to_register');
            $table->text('note')->nullable();
            $table->bigInteger('bank_id');
            $table->bigInteger('check_number');
            $table->dateTime('check_number_date');
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
        Schema::dropIfExists('cash_registers');
    }
};
