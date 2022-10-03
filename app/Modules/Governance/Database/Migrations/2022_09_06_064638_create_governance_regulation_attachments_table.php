<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Governance\Entities\{Regulation, RegulationAttachment};

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(RegulationAttachment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('media');
            $table->string('type');
            $table->foreignId('regulation_id')->constrained(Regulation::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists('governance_regulation_attachments');
    }
};
