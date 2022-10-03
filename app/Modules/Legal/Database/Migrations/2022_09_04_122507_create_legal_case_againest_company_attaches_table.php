<?php

use App\Modules\Legal\Entities\CaseAgainestCompany;
use App\Modules\Legal\Entities\CaseAgainestCompanyAttach;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CaseAgainestCompanyAttach::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('type', 50);
            $table->foreignId('case_anti_comp_id')->constrained(CaseAgainestCompany::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(CaseAgainestCompanyAttach::getTableName());
    }
};
