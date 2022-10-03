<?php

use App\Modules\Collection\Entities\Order;
use App\Modules\Collection\Entities\OrderAttachment;
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
        Schema::create(OrderAttachment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->foreignId('order_id')->constrained(Order::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(OrderAttachment::getTableName());
    }
};
