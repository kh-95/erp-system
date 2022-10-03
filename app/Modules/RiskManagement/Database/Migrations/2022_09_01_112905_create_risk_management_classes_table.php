<?php

use App\Modules\RiskManagement\Entities\Vendor;
use App\Modules\RiskManagement\Entities\VendorClass;
use App\Modules\RiskManagement\Entities\VendorClassTranslation;
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
        Schema::create(VendorClass::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create(VendorClassTranslation::getTableName(), function(Blueprint $table) {
            $table->id();
			$table->string('locale')->index();
			$table->string('name');
			$table->foreignId('vendor_class_id','risk_management_foreign_vendor_class')->constrained(VendorClass::getTableName())->cascadeOnDelete();
			$table->unique(['vendor_class_id', 'locale']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(VendorClassTranslation::getTableName());
		Schema::dropIfExists(VendorClass::getTableName());
    }
};
