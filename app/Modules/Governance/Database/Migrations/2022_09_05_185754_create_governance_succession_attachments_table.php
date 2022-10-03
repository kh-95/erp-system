<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Governance\Entities\SuccessionAttachment;
use App\Modules\Governance\Entities\Succession;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(SuccessionAttachment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('type', 50);
            $table->foreignId('succession_id')->constrained(Succession::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(SuccessionAttachment::getTableName());
    }
};
