<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\Management;
use App\Modules\Finance\Entities\Receipt;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Receipt::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->enum('pay_status',['check','moneyOrder']);
            $table->enum('customer_type',['cutomer', 'customer_with_service' , 'account']);
            $table->bigInteger('check_number')->nullable();
            $table->bigInteger('money_order_number')->nullable();
            $table->dateTime('receipt_date');
            $table->bigInteger('certificate_number');
            $table->dateTime('certificate_date');
            $table->double('money');
            $table->bigInteger('cash_register');
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
            $table->bigInteger('Receipt_request_number');
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
        Schema::dropIfExists('receipts');
    }
};
