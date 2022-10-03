<?php

use App\Modules\Governance\Entities\CandidacyApplication;
use App\Modules\HR\Entities\Nationality;
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
        Schema::create(CandidacyApplication::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('candidate_name');
            $table->string('identity_number');
            $table->date('application_date');
            $table->string('phone');
            $table->foreignId('nationality_id')->nullable()->constrained(Nationality::getTableName())->cascadeOnDelete();
            $table->enum('qualification_level', CandidacyApplication::QULAIFICATION_LEVELS);
            $table->string('qualification_name');
            $table->string('record_number')->unique();
            $table->string('record_subject');
            $table->enum('order_status', CandidacyApplication::ORDER_STATUSES);
            $table->string('reason_refuse');
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
        Schema::dropIfExists('governance_candidacyapplications');
    }
};
