<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Modules\HR\Entities\ContractClause;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\ContractClauseTranslation;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ContractClause::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create(ContractClauseTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->text('item_text');
            $table->string('nationality');
            $table->foreignId('contract_clause_id')->constrained(ContractClause::getTableName())->cascadeOnDelete();
            $table->string('locale');
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
        Schema::dropIfExists(ContractClauseTranslation::getTableName());
        Schema::dropIfExists(ContractClause::getTableName());
    }
};
