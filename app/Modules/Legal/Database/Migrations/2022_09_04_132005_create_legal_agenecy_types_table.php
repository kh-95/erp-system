<?php

use App\Modules\Legal\Entities\Agenecy;
use App\Modules\Legal\Entities\AgenecyType\AgenecyType;
use App\Modules\Legal\Entities\AgenecyType\AgenecyTypeTranslation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create(AgenecyType::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        Schema::create(AgenecyTypeTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenecy_type_id')->constrained(AgenecyType::getTableName())->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->string('locale')->index();

            $table->unique(['agenecy_type_id', 'locale']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(AgenecyTypeTranslation::getTableName());
        Schema::dropIfExists(AgenecyType::getTableName());
    }
};
