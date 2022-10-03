<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Interviews\InterviewCommitteeMember;
use App\Modules\HR\Entities\Interviews\Interview;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(InterviewCommitteeMember::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained(Interview::getTableName())->cascadeOnDelete();
            $table->foreignId('member_id')->constrained(Employee::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(InterviewCommitteeMember::getTableName());
    }
};
