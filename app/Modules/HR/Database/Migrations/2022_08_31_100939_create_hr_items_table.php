<?php

use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Items\Item;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\Items\ItemTranslation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Item::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->enum('type', Item::TYPE);
            $table->float('score');
            $table->foreignId('added_by_id')->nullable()->constrained(Employee::getTableName())->nullOnDelete();
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create(ItemTranslation::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained(Item::getTableName())->cascadeOnDelete();
            $table->string('name');
            $table->string('locale')->index();
            $table->unique(['item_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Item::getTableName());
        Schema::dropIfExists(ItemTranslation::getTableName());
    }
};
