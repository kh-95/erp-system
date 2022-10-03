<?php

use App\Modules\HR\Entities\Employee;
use App\Modules\User\Entities\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(User::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->string('employee_number')->unique();
            $table->string('image')->nullable();
            $table->string('password');
            $table->tinyInteger('is_send_otp')->default('0');
            $table->string('otp', 8)->nullable();
            $table->string('blocked_key')->nullable();
            $table->timestamp('deactivated_from')->nullable();
            $table->timestamp('deactivated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists(User::getTableName());
    }
};
