<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\Items\Item;
use App\Modules\HR\Entities\Interviews\InterviewApplication;
use App\Modules\HR\Entities\Interviews\InterviewApplicationItem;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(InterviewApplicationItem::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_application_id')->constrained(InterviewApplication::getTableName())->cascadeOnDelete();
            $table->foreignId('item_id')->constrained(Item::getTableName())->cascadeOnDelete();
            $table->float('score');
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
        Schema::dropIfExists(InterviewApplicationItem::getTableName());
    }
};
