<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Governance\Entities\{Regulation, RegulationTranslation};
use App\Modules\HR\Entities\Employee;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Regulation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->year('from_year');
            $table->year('to_year');
            $table->boolean('is_active')->default(true);
            $table->foreignId('added_by_id')->nullable()->constrained(Employee::getTableName())->nullOnDelete();
            $table->timestamps();
        });


        Schema::create(RegulationTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('regulation_id')->constrained(Regulation::getTableName())->cascadeOnDelete();
            $table->string('title');
            $table->string('description');
            $table->string('locale')->index();
            $table->unique(['regulation_id', 'locale']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Regulation::getTableName());
        Schema::dropIfExists(RegulationTranslation::getTableName());
    }
};
