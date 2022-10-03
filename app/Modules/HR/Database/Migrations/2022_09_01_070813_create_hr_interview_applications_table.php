<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\Interviews\Interview;
use App\Modules\HR\Entities\Interviews\InterviewApplication;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(InterviewApplication::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained(Interview::getTableName())->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('identity_number');
            $table->string('mobile');
            $table->date('interview_date');
            $table->text('note')->nullable();
            $table->float('total_score')->nullable();
            $table->boolean('recommended')->default(false);
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
        Schema::dropIfExists(InterviewApplication::getTableName());
    }
};
