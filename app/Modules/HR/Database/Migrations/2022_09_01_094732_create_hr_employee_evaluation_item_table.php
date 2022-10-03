<?php

use App\Modules\HR\Entities\EmployeeEvaluation;
use App\Modules\HR\Entities\EmployeeEvaluationItem;
use App\Modules\HR\Entities\Items\Item;
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
        Schema::create(EmployeeEvaluationItem::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_evaluation_id')->constrained(EmployeeEvaluation::getTableName())->cascadeOnDelete();
            $table->foreignId('item_id')->constrained(Item::getTableName())->cascadeOnDelete();
            $table->boolean('is_passed');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(EmployeeEvaluationItem::getTableName());
    }
};
