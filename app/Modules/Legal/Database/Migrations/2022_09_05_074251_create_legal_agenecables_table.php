<?php

use App\Modules\Legal\Entities\Agenecy;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('legal_agenecables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenecy_id')->constrained(Agenecy::getTableName())->cascadeOnDelete();
            $table->morphs('agenecable');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('legal_agenecables');
    }
};
