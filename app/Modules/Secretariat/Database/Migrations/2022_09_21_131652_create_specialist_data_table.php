<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\HR\Entities\{Management,Employee};
use App\Modules\Secretariat\Entities\{Message,SpecialistData};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(SpecialistData::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('management_id')->constrained(Management::getTableName())->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained(Employee::getTableName())->cascadeOnDelete();
            $table->foreignId('message_id')->constrained(Message::getTableName())->cascadeOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists('specialist_data');
    }
};
