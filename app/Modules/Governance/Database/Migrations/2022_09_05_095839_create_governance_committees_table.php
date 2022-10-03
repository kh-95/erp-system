<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Governance\Entities\Committee;
use App\Modules\Governance\Entities\CommitteeTranslation;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Committee::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->date('creation_date');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create(CommitteeTranslation::getTableName(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['committee_id', 'locale']);
            $table->foreignId('committee_id')->constrained(Committee::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(Committee::getTableName());
        Schema::dropIfExists(CommitteeTranslation::getTableName());
    }
};
