<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Secretariat\Entities\{Message,LegalData};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(LegalData::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_number');
            $table->bigInteger('legal_number');
            $table->foreignId('message_id')->constrained(Message::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists('legal_data');
    }
};
