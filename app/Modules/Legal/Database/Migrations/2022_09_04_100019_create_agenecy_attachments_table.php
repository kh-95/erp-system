<?php

use App\Modules\Legal\Entities\Agenecy;
use App\Modules\Legal\Entities\AgenecyAttachment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create(AgenecyAttachment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('media');
            $table->string('type');
            $table->foreignId('agenecy_id')->constrained(Agenecy::getTableName())->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(AgenecyAttachment::getTableName());
    }
};
