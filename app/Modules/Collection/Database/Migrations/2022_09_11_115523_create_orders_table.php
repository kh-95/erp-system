<?php

use App\Modules\Collection\Entities\Order;
use App\Modules\Collection\Entities\OrderTranslation;
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
        Schema::create(Order::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->integer('order_no');
            $table->enum('order_type', Order::ORDER_TYPES);
            $table->date('order_date');
            $table->enum('customer_type', ['mobile', 'identity']);
            $table->string('mobile')->nullable();
            $table->bigInteger('identity')->nullable();
            $table->foreignId('customer_id')->constrained(Customer::getTableName())->cascadeOnDelete();
			$table->timestamps();
        });

        Schema::create(OrderTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('order_subject');
            $table->text('order_text')->nullable();
            $table->foreignId('order_id')->constrained(Order::getTableName())->cascadeOnDelete();
            $table->unique(['order_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(OrderTranslation::getTableName());
        Schema::dropIfExists(Order::getTableName());
    }
};
