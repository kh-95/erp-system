<?php

use App\Modules\Governance\Entities\Meeting;
use App\Modules\Governance\Entities\MeetingPlace;
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
            $table->string('subject');
            $table->foreignId('meeting_place_id')->nullable()->constrained(MeetingPlace::getTableName())->nullOnDelete();
            $table->boolean('is_online')->default(false);
            $table->enum('meeting_types',Meeting::MEETING_TYPES);
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->boolean('for_full_time')->default(false);
            $table->enum('meeting_replication',Meeting::MEETING_REPLICATION)->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists(Meeting::getTableName());
    }
};
