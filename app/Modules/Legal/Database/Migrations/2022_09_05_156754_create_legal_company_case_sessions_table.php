<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Legal\Entities\CompanyCaseSession;
use App\Modules\Legal\Entities\CompanyCase;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CompanyCaseSession::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->date('session_date1');
            $table->date('session_date2');
            $table->text('notes')->nullable();
            $table->foreignId('company_case_id')->constrained(CompanyCase::getTableName())->cascadeOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists(CompanyCaseSession::getTableName());
    }
};
