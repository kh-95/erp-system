<?php

use App\Modules\Governance\Entities\StrategicPlan\StrategicPlan;
use App\Modules\Governance\Entities\StrategicPlanAttachment;
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
        Schema::create(StrategicPlanAttachment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('file')->nullable();
            $table->foreignId('strategic_plan_id')->constrained(StrategicPlan::getTableName())->cascadeOnDelete();

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
        Schema::dropIfExists(StrategicPlanAttachment::getTableName());
    }
};