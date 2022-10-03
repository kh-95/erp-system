<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
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
        Schema::create(Customer::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->enum('application',['jack', 'maeak']);
            $table->string('name');
            $table->bigInteger('indentity');
            $table->bigInteger('mobile');
            $table->bigInteger('contract_number');
            $table->dateTime('register_date');
            $table->double('money');
            $table->double('value_month');
            $table->double('value_transfer');
            $table->double('value_transfer_available');
            $table->double('premiums_paid');
            $table->double('premiums_owed');
            $table->double('price_owed');
            $table->double('price_stay');
            $table->string('law_situation');

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
        Schema::dropIfExists('customers');
    }
};
