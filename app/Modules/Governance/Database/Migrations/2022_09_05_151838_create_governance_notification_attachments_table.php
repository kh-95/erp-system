<?php

use App\Modules\Governance\Entities\Notification;
use App\Modules\Governance\Entities\NotificationAttachment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create(NotificationAttachment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('media');
            $table->string('type');
            $table->foreignId('notification_id')->constrained(Notification::getTableName())->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(NotificationAttachment::getTableName());
    }
};
