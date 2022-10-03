<?php

use App\Modules\Secretariat\Entities\Meeting;
use App\Modules\Secretariat\Entities\MeetingDecision;
use App\Modules\Secretariat\Entities\MeetingDecisionTranslation;
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
        Schema::create(MeetingDecision::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained(Meeting::getTableName())->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create(MeetingDecisionTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('locale')->index();
            $table->unique(['meeting_dec_id', 'locale']);
            $table->foreignId('meeting_dec_id')->constrained(MeetingDecision::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(MeetingDecisionTranslation::getTableName());
        Schema::dropIfExists(MeetingDecision::getTableName());
    }
};
