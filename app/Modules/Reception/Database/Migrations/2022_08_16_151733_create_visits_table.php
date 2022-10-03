<?php

use App\Modules\HR\Entities\Management;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Reception\Entities\Visit;
use App\Modules\Reception\Entities\VisitTranslation;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Visit::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->datetime('date');
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
            $table->enum('status', array('new', 'underway', 'finished', 'canceled'))->default('new');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create(VisitTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('type', 150);
            $table->text('note', 500)->nullable();
            $table->unique(['visit_id', 'locale']);
            $table->foreignId('visit_id')->constrained(Visit::getTableName())->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(VisitTranslation::getTableName());
        Schema::dropIfExists(Visit::getTableName());
    }
};
