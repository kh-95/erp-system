<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Modules\Finance\Entities\{AssetCategory, AssetCategoryTranslation,AccountingTree};

class CreateassetcategoryTable extends Migration {

	public function up()
	{
		Schema::create(AssetCategory::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->integer('revise_no');
			$table->foreignId('account_tree_id')->constrained(AccountingTree::getTableName())->cascadeOnDelete();
			$table->boolean('destroy_check')->default(0);
			$table->float('destroy_ratio');
			$table->timestamp('deactivated_at')->nullable();
			$table->SoftDeletes();
			$table->timestamps();
		});

		Schema::create(AssetCategoryTranslation::getTableName(), function(Blueprint $table) {
			$table->id();
			$table->string('locale')->index();
			$table->string('name');
			$table->string('notes');
			$table->foreignId('asset_category_id')->constrained(AssetCategory::getTableName())->cascadeOnDelete();
		});

	}

	public function down()
	{
		Schema::drop(AssetCategoryTranslation::getTableName());
		Schema::drop(AssetCategory::getTableName());
	}
}
