<?php

use App\Modules\CustomerService\Entities\Call;
use App\Modules\HR\Entities\Employee;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create(Call::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained(Employee::getTableName())->nullOnDelete();
            $table->foreignId('convert_to_employee_id')->nullable()->constrained(Employee::getTableName())->nullOnDelete();
            $table->string('duration');
            $table->string('client_name')->nullable();
            $table->string('client_identity_number')->nullable();
            $table->string('client_phone')->nullable();
            $table->float('rate')->nullable()->default(0);
            $table->enum('status', Call::STATUSES);
            $table->string('media');
            $table->string('waiting_time_in_queue')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Call::getTableName());
    }
};
