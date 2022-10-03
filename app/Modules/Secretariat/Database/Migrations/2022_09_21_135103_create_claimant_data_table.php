<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Secretariat\Entities\{Message,ClaimantData};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ClaimantData::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->enum('customer_type',['customer','customerWService']);
            $table->bigInteger('contract_number')->nullable();
            $table->bigInteger('identity_number')->nullable();
            $table->string('name',100)->nullable();
            $table->string('mobile',100)->nullable();
            $table->bigInteger('register_number')->nullable();
            $table->bigInteger('tax_number')->nullable();
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
        Schema::dropIfExists('claimant_data');
    }
};
