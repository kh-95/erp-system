<?php

use App\Modules\Finance\Entities\AccountingTree;
use App\Modules\Finance\Entities\AccountingTreeTranslation;
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
        Schema::create(AccountingTree::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->integer('revise_no')->default(0);
            $table->integer('parent_id')->default(0);
            $table->boolean('payment_check')->default(0);
            $table->boolean('collect_check')->default(0);
            $table->string('account_code');
            $table->timestamp('deactivated_at')->nullable();
			$table->softDeletes();
			$table->timestamps();
        });

        Schema::create(AccountingTreeTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('account_name');
            $table->text('notes')->nullable();
            $table->foreignId('accounting_tree_id')->constrained(AccountingTree::getTableName())->cascadeOnDelete();
            $table->unique(['accounting_tree_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(AccountingTreeTranslation::getTableName());
        Schema::dropIfExists(AccountingTree::getTableName());

    }
};
