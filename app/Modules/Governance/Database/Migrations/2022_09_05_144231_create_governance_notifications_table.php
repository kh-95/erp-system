<?php

use App\Modules\Governance\Entities\Notification;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create(Notification::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->enum('status',['not seen', 'viewed', 'replied']);
            $table->string('response');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Notification::getTableName());
    }
};
