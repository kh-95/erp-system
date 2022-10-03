<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\RiskManagement\Entities\Vendor;
use App\Modules\RiskManagement\Entities\VendorAttachment;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(VendorAttachment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('type', 50);
            $table->foreignId('vendor_id')->constrained(Vendor::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(VendorAttachment::getTableName());
    }
};
