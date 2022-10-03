<?php

use App\Modules\HR\Entities\SalaryApprove;
use App\Modules\User\Entities\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\Employee;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(SalaryApprove::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->date('month')->nullable();
            $table->boolean('is_signed')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->foreignId('added_by_id')->nullable()->constrained(Employee::getTableName())->nullOnDelete();
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
        Schema::dropIfExists(SalaryApprove::getTableName());
    }
};
