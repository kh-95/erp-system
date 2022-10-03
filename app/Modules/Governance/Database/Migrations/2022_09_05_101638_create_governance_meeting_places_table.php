<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Governance\Entities\MeetingPlace;
use App\Modules\Governance\Entities\MeetingPlaceTranslation;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create(MeetingPlace::getTableName(), function (Blueprint $table) {
                $table->id();
                $table->date('deactivated_at')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });

            Schema::create(MeetingPlaceTranslation::getTableName(), function (Blueprint $table) {
                $table->increments('id');
                $table->string('locale')->index();
                $table->string('name');
                $table->unique(['place_id', 'locale']);
                $table->foreignId('place_id')->constrained(MeetingPlace::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(MeetingPlace::getTableName());
        Schema::dropIfExists(MeetingPlaceTranslation::getTableName());

    }
};
