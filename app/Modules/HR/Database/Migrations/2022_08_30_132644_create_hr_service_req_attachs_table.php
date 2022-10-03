<?php

use App\Modules\HR\Entities\ServiceReqAttach;
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
        Schema::create(ServiceReqAttach::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->foreignId('service_req_id')->constrained(ServiceReqAttach::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(ServiceReqAttach::getTableName());
    }
};
