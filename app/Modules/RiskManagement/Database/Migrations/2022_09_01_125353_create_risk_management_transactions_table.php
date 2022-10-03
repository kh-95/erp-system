<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\RiskManagement\Entities\Transaction;
use App\Modules\RiskManagement\Entities\Vendor;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Transaction::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number');
            $table->string('amount');
            $table->foreignId('vendor_id')->constrained(Vendor::getTableName())->cascadeOnDelete();
            $table->enum('payment_type', Transaction::TYPES);
            $table->string('payment_type_ar');  // using for sorting only
            $table->enum('payment_status', Transaction::STATUS);
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
        Schema::dropIfExists('riskmanagement_transactions');
    }
};
