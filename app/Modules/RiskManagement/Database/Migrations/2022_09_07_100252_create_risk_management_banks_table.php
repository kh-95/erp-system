<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\RiskManagement\Entities\Bank;
use App\Modules\RiskManagement\Entities\BankTranslation;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Bank::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create(BankTranslation::getTableName(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['bank_id', 'locale']);
            $table->foreignId('bank_id')->constrained(Bank::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(Bank::getTableName());
        Schema::dropIfExists(BankTranslation::getTableName());

    }
};
