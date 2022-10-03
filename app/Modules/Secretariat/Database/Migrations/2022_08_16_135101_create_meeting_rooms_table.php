<?php

use App\Modules\Secretariat\Entities\MeetingRoom;
use App\Modules\Secretariat\Entities\MeetingRoomTranslation;
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
        Schema::create(MeetingRoom::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create(MeetingRoomTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('locale')->index();
            $table->unique(['meeting_room_id', 'locale']);
            $table->foreignId('meeting_room_id')->constrained(MeetingRoom::getTableName())->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(MeetingRoomTranslation::getTableName());
        Schema::dropIfExists(MeetingRoom::getTableName());
    }
};
