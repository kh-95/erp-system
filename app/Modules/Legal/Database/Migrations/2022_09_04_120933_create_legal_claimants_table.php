<?php

use App\Modules\Legal\Entities\CaseAgainestCompany;
use App\Modules\Legal\Entities\Claimant;
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
        Schema::create(Claimant::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('claimant_name');
            $table->string('identity_number');
            $table->foreignId('case_againest_company_id')->constrained(CaseAgainestCompany::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(Claimant::getTableName());
    }
};
