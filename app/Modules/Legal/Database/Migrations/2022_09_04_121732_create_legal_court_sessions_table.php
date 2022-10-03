<?php

use App\Modules\Legal\Entities\CaseAgainestCompany;
use App\Modules\Legal\Entities\CourtSession;
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
        Schema::create(CourtSession::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->date('session_date');
            $table->date('session_date_hijri');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists(CourtSession::getTableName());
    }
};
