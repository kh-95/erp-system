<?php

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\PermissionRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::create(PermissionRequest::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('permission_number')->unique();
            $table->foreignId('employee_manager_id')->nullable()->constrained(Employee::getTableName())->nullOnDelete();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->timestamp('date');
            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->enum('from_duration', PermissionRequest::DURATION)->nullable();
            $table->enum('to_duration', PermissionRequest::DURATION)->nullable();
//            $table->enum('type', PermissionRequest::TYPES);
//            $table->text('hr_notes')->nullable();
//            $table->text('manager_notes')->nullable();
            $table->text('notes')->nullable();

            $table->integer('permission_duration');
            $table->double('deduct_amount');
            $table->enum('direct_manager_status', PermissionRequest::MANAGER_STATUSES);
            $table->enum('hr_status', PermissionRequest::HR_STATUSES);
            $table->timestamp('manager_action_at')->nullable();
            $table->timestamp('hr_action_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(PermissionRequest::getTableName());
    }
};
