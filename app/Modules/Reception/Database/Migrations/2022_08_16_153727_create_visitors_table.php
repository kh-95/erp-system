<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Reception\Entities\Visit;
use App\Modules\Reception\Entities\Visitor;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Visitor::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('identity_number', 12);
            $table->foreignId('visit_id')->constrained(Visit::getTableName())->cascadeOnDelete();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists(Visitor::getTableName());
    }
};
