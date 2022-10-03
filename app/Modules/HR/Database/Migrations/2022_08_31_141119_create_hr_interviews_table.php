<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\Interviews\Interview;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Interview::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('added_by_id')->nullable()->constrained(Employee::getTableName())->nullOnDelete();
            $table->foreignId('job_id')->constrained(Job::getTableName())->cascadeOnDelete();
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
        Schema::dropIfExists(Interview::getTableName());
    }
};
