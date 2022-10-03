<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\Setting;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Setting::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->time('attend_time');
            $table->time('leave_time');
            $table->string('month_Date');
            $table->integer('permission_duration');
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
        Schema::dropIfExists(Setting::getTableName());
    }
};
