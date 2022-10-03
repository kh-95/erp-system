<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\RiskManagement\Entities\Transaction;
use App\Modules\RiskManagement\Entities\TransactionAttachment;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TransactionAttachment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('type', 50);
            $table->foreignId('transaction_id')->constrained(Transaction::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(TransactionAttachment::getTableName());
    }
};
