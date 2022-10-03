<?php

use App\Modules\HR\Entities\BlackList;
use App\Modules\HR\Entities\Employee;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(BlackList::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('identity_number');
            $table->text('reason');
            $table->string('phone');
            $table->foreignId('employee_id')->nullable()->constrained(Employee::getTableName())->nullOnDelete();
            $table->enum('type',BlackList::BLACK_LIST_TYPES);
            $table->enum('employee_type', BlackList::EMPLOYEE_TYPE);
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
        Schema::dropIfExists(BlackList::getTableName());
    }
};
