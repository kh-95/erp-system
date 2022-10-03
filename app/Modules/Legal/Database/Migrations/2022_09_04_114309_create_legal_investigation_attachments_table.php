<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Legal\Entities\Investigation;



return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_investigation_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('type', 50);
             $table->foreignId('investigation_id')->constrained(Investigation::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists('legal_investigation_attachments');
    }
};
