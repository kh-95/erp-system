<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\DeductBonus;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DeductBonus::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('added_by_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->enum('action_type', DeductBonus::ACTION_TYPE);
            $table->float('amount', 15, 2);
            $table->enum('duration_type', DeductBonus::DURATION_TYPE)->nullable();
            $table->enum('type', DeductBonus::TYPE);
            $table->float('duration')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('status', DeductBonus::STATUSES)->default(DeductBonus::PENDING);
            $table->timestamp('applicable_at')->nullable();
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
        Schema::dropIfExists(DeductBonus::getTableName());
    }
};
