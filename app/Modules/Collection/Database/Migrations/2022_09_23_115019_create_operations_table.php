<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Collection\Entities\Operation;
use App\Modules\TempApplication\Entities\Customer;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Operation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('operation_number')->unique();
            $table->double('amount');
            $table->foreignId('customer_id')->nullable()->constrained(Customer::getTableName())->nullOnDelete();
            $table->foreignId('installment_id')->nullable();
            $table->string('customer_service_id')->nullable();
            $table->enum('status',['completed', 'not_completed', 'failed']);
            $table->dateTime('date');
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
        Schema::dropIfExists('operations');
    }
};
