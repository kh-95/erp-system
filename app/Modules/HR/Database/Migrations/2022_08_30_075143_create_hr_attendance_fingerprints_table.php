<?php

use App\Modules\HR\Entities\AttendanceFingerprint;
use App\Modules\HR\Entities\Employee;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create(AttendanceFingerprint::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->timestamp('attended_at')->nullable();
            $table->timestamp('leaved_at')->nullable();
            $table->enum('method', AttendanceFingerprint::METHODS);
            $table->enum('branch', AttendanceFingerprint::BRANCHES);
            $table->boolean('has_vacation')->default(0);
            $table->boolean('has_permission')->default(0);
            $table->enum('punishment', AttendanceFingerprint::PUNISHMENT)->nullable();
            $table->enum('punishment_status', AttendanceFingerprint::PUNISHMENT_STATUS)->default(AttendanceFingerprint::WAITING);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(AttendanceFingerprint::getTableName());
    }
};
