<?php

use App\Modules\HR\Entities\Employee;
use App\Modules\Secretariat\Entities\Meeting;
use App\Modules\Secretariat\Entities\MeetingTranslation;
use App\Modules\Secretariat\Entities\MeetingRoom;
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
        Schema::create(Meeting::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->datetime('meeting_date');
            $table->foreignId('meeting_room_id')->constrained(MeetingRoom::getTableName())->cascadeOnDelete();
            $table->smallInteger('meeting_duration')->nullable();
            $table->enum('type', ['cyclic', 'sudden', 'suitable']);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create(MeetingTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->text('note');
            $table->string('locale')->index();
            $table->unique(['meeting_id', 'locale']);
            $table->foreignId('meeting_id')->constrained(Meeting::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(MeetingTranslation::getTableName());
        Schema::dropIfExists(Meeting::getTableName());
    }
};
