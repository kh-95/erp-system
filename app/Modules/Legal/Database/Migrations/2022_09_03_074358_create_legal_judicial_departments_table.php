<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Legal\Entities\JudicialDepartment\JudicialDepartment;
use App\Modules\Legal\Entities\JudicialDepartment\JudicialDepartmentTranslation;

return new class extends Migration
{
    public function up()
    {
        Schema::create(JudicialDepartment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('area')->nullable(); //waiting...
            $table->string('court')->nullable(); //waiting...
            $table->string('email')->nullable();

            $table->timestamps();
        });

        Schema::create(JudicialDepartmentTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('judicial_department_id');
            $table->foreign('judicial_department_id', 'jud_dep_fk')->references('id')->on(JudicialDepartment::getTableName())->onDelete('CASCADE');
            $table->string('name');
            $table->text('description');
            $table->string('locale')->index();

            $table->unique(['judicial_department_id', 'locale'], 'legal_jud_dep_trans_id_locale_unique');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(JudicialDepartmentTranslation::getTableName());
        Schema::dropIfExists(JudicialDepartment::getTableName());
    }
};
