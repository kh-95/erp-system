<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\RiskManagement\Entities\Vendor;
use App\Modules\RiskManagement\Entities\VendorClass;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Vendor::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained(VendorClass::getTableName())->cascadeOnDelete();
            $table->string('name');
            $table->string('identity_number')->unique();
            $table->string('commercial_record');
            $table->string('tax_number');
            $table->string('rasid_jack')->default(0);
            $table->string('rasid_maak')->default(0);
            $table->string('rasid_pay')->default(0);
            $table->string('total_pays');
            $table->string('daily_expected_sales_amount')->default(0);
            $table->string('daily_expected_activity_amount')->default(0);
            $table->boolean('maak_service_provider')->default(false);
            $table->boolean('pay_service_provider')->default(false);
            $table->enum('type', Vendor::TYPES);
            $table->enum('subscription', Vendor::SUBSCRIPTIONS);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('riskmanagement_vendors');
    }
};
