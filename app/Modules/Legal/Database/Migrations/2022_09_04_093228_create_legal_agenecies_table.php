<?php

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use App\Modules\Legal\Entities\Agenecy;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create(Agenecy::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_management_id')->nullable()->constrained(Management::getTableName())->nullOnDelete();
            $table->foreignId('client_employee_id')->nullable()->constrained(Employee::getTableName())->nullOnDelete();
            $table->enum('client_agenecy_as', Agenecy::AGENECY_AS);
            $table->foreignId('previous_agenecy_id')->nullable()->constrained(Agenecy::getTableName())->nullOnDelete();

            $table->foreignId('agent_management_id')->nullable()->constrained(Management::getTableName())->nullOnDelete();
            $table->foreignId('agent_employee_id')->nullable()->constrained(Employee::getTableName())->nullOnDelete();

            $table->string('agenecy_number')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();

            $table->enum('duration_type', Agenecy::DURATION_TYPE);
            $table->string('duration')->nullable();
            $table->timestamp('hijiry_end_date')->nullable();
            $table->timestamp('milady_end_date')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Agenecy::getTableName());
    }
};
