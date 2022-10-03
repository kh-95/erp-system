<?php

use App\Modules\Legal\Entities\StaticText\StaticText;
use App\Modules\Legal\Entities\StaticText\StaticTextTranslation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create(StaticText::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        Schema::create(StaticTextTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('static_text_id')->constrained(StaticText::getTableName())->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->string('locale')->index();

            $table->unique(['static_text_id', 'locale']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(StaticTextTranslation::getTableName());
        Schema::dropIfExists(StaticText::getTableName());
    }
};
