<?php

use App\Modules\HR\Entities\Employee;
use App\Modules\User\Entities\User;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\{ServiceRequest,ServiceRequestTranslation};
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ServiceRequest::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('management_id')->nullable()->constrained(Management::getTableName())->nullOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained(Employee::getTableName())->nullOnDelete();
            $table->string('service_type');
            $table->string('directed_to');
            $table->enum('status',['sent','waiting','show','responsed'])->nullable();
            $table->foreignId('user_id')->nullable()->constrained(User::getTableName())->nullOnDelete();
            $table->timestamps();
        });

        Schema::create(ServiceRequestTranslation::getTableName(), function (Blueprint $table) {
            $table->string('locale')->index();
            $table->text('notes')->nullable();
            $table->unique(['ser_req_id', 'locale']);
            $table->foreignId('ser_req_id')->constrained(ServiceRequest::getTableName())->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(ServiceRequestTranslation::getTableName());
        Schema::dropIfExists(ServiceRequest::getTableName());
    }
};
