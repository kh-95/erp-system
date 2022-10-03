<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Finance\Entities\CashRegister;
use App\Modules\Finance\Entities\CashRegisterAttachments;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CashRegisterAttachments::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->foreignId('cashregister_id')->constrained(CashRegister::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists('cash_register_attachments');
    }
};
