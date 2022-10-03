<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\Management;
use App\Modules\Finance\Entities\Notification;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Notification::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['adding', 'equation', 'discount']);
            $table->enum('way', ['customer', 'customerWithService']);
            $table->bigInteger('notification_number');
            $table->dateTime('date');
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
            $table->string('notification_name');
            $table->double('price');
            $table->bigInteger('complaint_number');
            $table->text('note');
            $table->bigInteger('customer_id');
            $table->bigInteger('to_customer_id')->nullable();
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
        Schema::dropIfExists(Notification::getTableName());
    }
};
