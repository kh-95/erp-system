<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Legal\Entities\{Order, OrderAttachment};

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
            $table->string('media');
            $table->string('type');
            $table->foreignId('order_id')->constrained(Order::getTableName())->cascadeOnDelete();
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
