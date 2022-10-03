<?php

use App\Modules\Governance\Entities\Meeting;
use App\Modules\Governance\Entities\MeetingAttachment;
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
        Schema::create(MeetingAttachment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->enum('type', Meeting::ATTACHMENT_TYPES);
            $table->foreignId('meeting_id')->constrained(Meeting::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(MeetingAttachment::getTableName());
    }
};
