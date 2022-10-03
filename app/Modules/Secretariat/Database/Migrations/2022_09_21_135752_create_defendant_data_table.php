<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Secretariat\Entities\{Message,DefendantData};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DefendantData::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->enum('customer_type',['company','private']);
            $table->enum('branch',['rasidHolding','tasahil'])->nullable();
            $table->bigInteger('register_number')->nullable();
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
        Schema::dropIfExists('defendant_data');
    }
};
