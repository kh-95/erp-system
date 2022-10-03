<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Governance\Entities\StrategicPlan\StrategicPlan;
use App\Modules\Governance\Entities\StrategicPlan\StrategicPlanTranslation;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(StrategicPlan::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('achieved')->default(0)->comment('0% to 100%');
            $table->unsignedInteger('from')->nullable()->comment('Year');
            $table->unsignedInteger('to')->nullable()->comment('Year');

            $table->timestamps();
        });

        Schema::create(StrategicPlanTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('strategic_plan_id')->constrained(StrategicPlan::getTableName())->cascadeOnDelete();
            $table->string('title');
            $table->text('vision');
            $table->string('locale')->index();

            $table->unique(['strategic_plan_id', 'locale'], 'gc_strategic_plan_trans_id_locale_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists(StrategicPlanTranslation::getTableName());
        Schema::dropIfExists(StrategicPlan::getTableName());
    }
};
