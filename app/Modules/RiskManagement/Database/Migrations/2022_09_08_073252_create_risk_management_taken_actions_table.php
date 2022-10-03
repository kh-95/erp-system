<?php

use App\Modules\RiskManagement\Entities\NotificationVendor;
use App\Modules\RiskManagement\Entities\TakenAction;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create(TakenAction::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->enum('taken_action', NotificationVendor::TAKEN_ACTIONS);
            $table->text('reasons');
            $table->foreignId('notification_vendor_id')->constrained(NotificationVendor::getTableName())->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TakenAction::getTableName());
    }
};
