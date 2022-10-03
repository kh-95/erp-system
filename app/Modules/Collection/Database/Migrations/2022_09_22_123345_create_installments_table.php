<?php

use App\Modules\Collection\Entities\Installment;
use App\Modules\TempApplication\Entities\Customer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Nwidart\Modules\Process\Installer;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Installment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained(Customer::getTableName())->nullOnDelete();
            $table->unsignedInteger('date_from')->nullable()->comment('Year');
            $table->unsignedInteger('date_to')->nullable()->comment('Year');
            $table->float('amount_from');
            $table->float('amount_to');
            $table->enum('status',['waiting_eligibility','worthy','paid','late']);
            $table->date('date_entitlement');
            $table->string('penalty_value_delay')->nullable();
            $table->string('customer_service_id')->nullable();
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
        Schema::dropIfExists('installments');
    }
};
