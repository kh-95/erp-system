<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Finance\Entities\{Receipt,ReceiptAttachment};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ReceiptAttachment::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->foreignId('receipt_id')->constrained(Receipt::getTableName())->cascadeOnDelete();
            $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt_attachments');
    }
};
