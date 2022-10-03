<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Legal\Entities\CompanyCaseAttachment;
use App\Modules\Legal\Entities\CompanyCase;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CompanyCaseAttachment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('type', 50);
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
        Schema::dropIfExists(CompanyCaseAttachment::getTableName());
    }
};
