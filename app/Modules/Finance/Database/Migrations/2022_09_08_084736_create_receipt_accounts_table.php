<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Finance\Entities\{Receipt,ReceiptAccount};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ReceiptAccount::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('account_sympolize');
            $table->bigInteger('iban');
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
        Schema::dropIfExists('receipt_accounts');
    }
};
