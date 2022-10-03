<?php

use App\Modules\HR\Entities\{Custody, Employee};
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
        Schema::create(Custody::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->unsignedSmallInteger('count')->nullable();
            $table->text('description')->nullable();
            $table->date('received_date');
            $table->date('delivery_date')->nullable();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists(Custody::getTableName());
    }
};
