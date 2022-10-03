<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Finance\Entities\{Receipt,ReceiptCustomerType};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ReceiptCustomerType::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id');
            $table->bigInteger('customer_identity');
            $table->bigInteger('phone');
            $table->enum('premium',['waiting', 'late' , 'owed']);
            $table->bigInteger('premium_number');
            $table->dateTime('premium_date');
            $table->double('premium_value');
            $table->foreignId('receipt_id')->constrained(Receipt::getTableName())->cascadeOnDelete();

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
        Schema::dropIfExists('receipt_customer_types');
    }
};
