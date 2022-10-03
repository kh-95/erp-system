<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Governance\Entities\CommitteeEmployee;
use App\Modules\Governance\Entities\Committee;
use App\Modules\HR\Entities\Employee;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CommitteeEmployee::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('committee_id')->constrained(Committee::getTableName())->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->boolean('is_president')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(CommitteeEmployee::getTableName());
    }
};
