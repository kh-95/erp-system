<?php

use App\Modules\Legal\Entities\AgenecyTerm\AgenecyTerm;
use App\Modules\Legal\Entities\AgenecyTerm\AgenecyTermTranslation;
use App\Modules\Legal\Entities\AgenecyType\AgenecyType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create(AgenecyTerm::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->foreignId('agenecy_type_id')->nullable()->constrained(AgenecyType::getTableName())->nullOnDelete();

            $table->timestamps();
        });

        Schema::create(AgenecyTermTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenecy_term_id')->constrained(AgenecyTerm::getTableName())->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->string('locale')->index();

            $table->unique(['agenecy_term_id', 'locale']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(AgenecyTermTranslation::getTableName());
        Schema::dropIfExists(AgenecyTerm::getTableName());
    }
};
