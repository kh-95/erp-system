<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\ManagementTranslation;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Management::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained(Management::getTableName())->nullOnDelete();
            $table->boolean('status')->default(true);
            $table->date('deactivated_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create(ManagementTranslation::getTableName(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unique(['management_id','locale']);
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Management::getTableName());
        Schema::dropIfExists(ManagementTranslation::getTableName());

    }
};
