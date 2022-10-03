<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Governance\Entities\StrategicPlan\StrategicPlan;
use App\Modules\Governance\Entities\StrategicPlan\StrategicPlanAttribute;
use App\Modules\Governance\Entities\StrategicPlan\StrategicPlanAttributeTranslation;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(StrategicPlanAttribute::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('strategic_plan_id')->constrained(StrategicPlan::getTableName())->cascadeOnDelete();
            $table->enum('type', StrategicPlanAttribute::TYPES)->nullable();
            $table->timestamps();
        });

        Schema::create(StrategicPlanAttributeTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('strategic_plan_attribute_id');
            $table->foreign('strategic_plan_attribute_id', 'gc_strategic_plan_fk')->references('id')->on(StrategicPlanAttribute::getTableName())->onDelete('CASCADE');

            $table->string('value')->nullable();
            $table->string('achievement_method')->nullable();
            $table->string('locale')->index();

            $table->unique(['strategic_plan_attribute_id', 'locale'], 'gc_strategic_plan_trans_id_locale_unique');
        });
    }



    public function down()
    {

        Schema::dropIfExists(StrategicPlanAttributeTranslation::getTableName());
        Schema::dropIfExists(StrategicPlanAttribute::getTableName());
    }
};
