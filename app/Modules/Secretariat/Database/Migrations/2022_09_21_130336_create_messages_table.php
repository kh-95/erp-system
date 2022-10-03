<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Secretariat\Entities\{Message,SpecialistData};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Message::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->bigInteger('message_number');
            $table->string('source');
            $table->date('message_date');
            $table->date('message_recieve_date');
            $table->text('message_body');
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
        Schema::dropIfExists('messages');
    }
};
