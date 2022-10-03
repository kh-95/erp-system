<?php

use App\Modules\Legal\Entities\Order;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\Employee;
use App\Modules\User\Entities\User;
use App\Modules\HR\Entities\Management;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Order::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->foreignId('added_by_id')->nullable()->constrained(User::getTableName())->nullOnDelete();
            $table->string('request_subject');
            $table->enum('type', Order::REQUEST_TYPES);
            $table->enum('status', Order::REQUEST_Status)->nullable();
            $table->date('request_date');
            $table->date('islamic_date');
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
        Schema::dropIfExists(Order::getTableName());
    }
};
