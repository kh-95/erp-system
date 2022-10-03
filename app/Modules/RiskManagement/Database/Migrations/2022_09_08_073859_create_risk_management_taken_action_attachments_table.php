<?php

use App\Modules\RiskManagement\Entities\TakenAction;
use App\Modules\RiskManagement\Entities\TakenActionAttachment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create(TakenActionAttachment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('type', 50);
            $table->foreignId('taken_action_id')->constrained(TakenAction::getTableName())->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TakenActionAttachment::getTableName());
    }
};
