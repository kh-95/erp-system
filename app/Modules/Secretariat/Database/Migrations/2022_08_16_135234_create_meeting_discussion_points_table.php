<?php

use App\Modules\Secretariat\Entities\Meeting;
use App\Modules\Secretariat\Entities\MeetingDiscussionPoint;
use App\Modules\Secretariat\Entities\MeetingDiscussionPointTranslation;
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
        Schema::create(MeetingDiscussionPoint::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained(Meeting::getTableName())->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create(MeetingDiscussionPointTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('locale')->index();
            $table->unique(['dess_id', 'locale']);
            $table->foreignId('dess_id')->constrained(MeetingDiscussionPoint::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(MeetingDiscussionPointTranslation::getTableName());
        Schema::dropIfExists(MeetingDiscussionPoint::getTableName());
    }
};
