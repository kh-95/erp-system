<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Legal\Entities\{Consult,Order};
use App\Modules\User\Entities\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Consult::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('text',100);
            $table->enum('status', Order::REQUEST_Status)->nullable();
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
        Schema::dropIfExists(Consult::getTableName());
    }
};
