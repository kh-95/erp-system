<?php

use App\Modules\RiskManagement\Entities\Bank;
use App\Modules\RiskManagement\Entities\BankVendor;
use App\Modules\RiskManagement\Entities\Vendor;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create(BankVendor::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->constrained(Bank::getTableName())->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained(Vendor::getTableName())->cascadeOnDelete();
            $table->enum('status', BankVendor::STATUS);
            $table->string('iban');
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
        Schema::dropIfExists(BankVendor::getTableName());
    }
};
