<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\{ServiceResponse,ServiceResponseTranslation};
use App\Modules\HR\Entities\ServiceRequest;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ServiceResponse::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->constrained(ServiceRequest::getTableName())->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create(ServiceResponseTranslation::getTableName(), function (Blueprint $table) {
            $table->string('locale')->index();
            $table->text('note')->nullable();
            $table->unique(['ser_res_id', 'locale']);
            $table->foreignId('ser_res_id')->constrained(ServiceResponse::getTableName())->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(ServiceResponseTranslation::getTableName());
        Schema::dropIfExists(ServiceResponse::getTableName());
    }
};
