<?php

use App\Modules\HR\Entities\Employee;
use App\Modules\User\Entities\User;
use App\Modules\Legal\Entities\Consult;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Legal\Entities\LegalOpinion;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(LegalOpinion::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->foreignId('consult_id')->constrained(Consult::getTableName())->cascadeOnDelete();
            $table->foreignId('added_by_id')->constrained(User::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(LegalOpinion::getTableName());
    }
};
