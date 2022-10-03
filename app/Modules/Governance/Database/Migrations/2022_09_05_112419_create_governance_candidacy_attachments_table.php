<?php

use App\Modules\Governance\Entities\CandidacyApplication;
use App\Modules\Governance\Entities\CandidacyAttachment;
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
        Schema::create(CandidacyAttachment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('media');
            $table->string('type');
            $table->foreignId('candidacy_id')->constrained(CandidacyApplication::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists('candidacy_attachments');
    }
};
