<?php

use App\Modules\RiskManagement\Entities\Notification;
use App\Modules\RiskManagement\Entities\NotificationVendor;
use App\Modules\RiskManagement\Entities\Vendor;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create(NotificationVendor::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained(Vendor::getTableName())->cascadeOnDelete();
            $table->foreignId('notification_id')->nullable()->constrained(Notification::getTableName())->nullOnDelete();
            $table->string('title')->nullable();
            $table->text('body')->nullable();

            $table->enum('taken_action', NotificationVendor::TAKEN_ACTIONS);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(NotificationVendor::getTableName());
    }
};
