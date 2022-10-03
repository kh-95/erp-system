<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Nationality;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Employee::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('nationality_id')->nullable()->constrained(Nationality::getTableName())->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->string('identification_number', 10);
            $table->string('first_name', 60);
            $table->string('second_name', 60);
            $table->string('third_name', 60);
            $table->string('last_name', 60);
            $table->string('phone');
            $table->date('identity_date');
            $table->string('identity_source');
            $table->date('date_of_birth');
            $table->enum('marital_status', array('single', 'married', 'separated', 'widowed'));
            $table->string('email', 60);
            $table->enum('gender', array('male', 'female'));
            $table->enum('qualification', Employee::QULAIFICATION_LEVELS);
            $table->string('address', 120);
            $table->enum('company', array('rasidholding', 'tasahel', 'rasid', 'fintech'));
            $table->tinyInteger('directorate')->default(0);
            $table->timestamp('deactivated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->boolean('is_directorship_president')->default(false);
            $table->boolean('is_customer_service')->default(false);
            $table->enum('call_status',Employee::CALL_STATUSES);


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
        Schema::dropIfExists(Employee::getTableName());
    }
};
