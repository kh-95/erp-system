<?php

use App\Modules\RiskManagement\Entities\Notification;
use App\Modules\RiskManagement\Entities\NotificationTerm;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create(NotificationTerm::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->enum('field', NotificationTerm::FIELDS);
            $table->enum('operator', NotificationTerm::OPERATORS);
            $table->enum('join_operator', NotificationTerm::JOIN_OPERATORS)->nullable()->default(null);
            $table->integer('order');
            $table->foreignId('notification_id')->constrained(Notification::getTableName())->cascadeOnDelete();
            $table->string('value');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(NotificationTerm::getTableName());
    }
};
