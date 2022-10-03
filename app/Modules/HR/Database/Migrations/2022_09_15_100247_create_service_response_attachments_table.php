<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\{ServiceResponse,ServiceResponseAttachment};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ServiceResponseAttachment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->foreignId('service_res_id')->constrained(ServiceResponse::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists('service_response_attachments');
    }
};
