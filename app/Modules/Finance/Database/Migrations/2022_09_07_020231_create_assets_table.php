<?php

use Illuminate\Support\Facades\Schema;
use App\Modules\Finance\Entities\Asset;
use App\Modules\Finance\Entities\AssetTranslation;
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
        Schema::create(Asset::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date');
            $table->date('operation_date');
            $table->string('measure_value');
            $table->text('barcode');
            $table->string('account');
            $table->double('value');
            $table->double('scrap_value');
            $table->date('expiration_date');
            $table->boolean('is_depreciable');
            $table->double('depreciation_fees')->nullable();
            $table->string('total_depreciation_fees')->nullable();
            $table->boolean('is_assurance_exists');
            $table->date('assurance_expiration_date');
            $table->string('attachments')->nullable();
            $table->timestamps();
        });

        Schema::create(AssetTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->string('measure_unit');
            $table->string('tax');
            $table->text('description')->nullable();
            $table->foreignId('asset_id')->constrained(Asset::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(AssetTranslation::getTableName());
        Schema::dropIfExists(Asset::getTableName());
    }
};
