<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Governance\Entities\Succession;
use App\Modules\Governance\Entities\SuccessionItem;


return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(SuccessionItem::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('succession_id')->constrained(Succession::getTableName())->cascadeOnDelete();
            $table->text('item');
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
        Schema::dropIfExists(SuccessionItem::getTableName());
    }
};
