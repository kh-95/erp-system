<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Governance\Entities\Succession;
use App\Modules\Governance\Entities\SuccessionTranslation;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\Job;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Succession::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(1);
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
            $table->foreignId('job_id')->constrained(Job::getTableName())->cascadeOnDelete();
            $table->string('percentage');
            $table->string('plan_from');
            $table->string('plan_to');
            $table->timestamps();
        });


        Schema::create(SuccessionTranslation::getTableName(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['succession_id', 'locale']);
            $table->foreignId('succession_id')->constrained(Succession::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(Succession::getTableName());
        Schema::dropIfExists(SuccessionTranslation::getTableName());
    }
};
