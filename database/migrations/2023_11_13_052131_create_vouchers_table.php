<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('month_date');
            $table->string('voucher_no');
            $table->string('description');
            $table->decimal('amount', 15, 2);
            $table->string('payee');
            $table->string('category');
            $table->string('paid_to');
            $table->string('note');
            $table->foreignId('bank_id')->nullable()->constrained('bank_id');
            $table->foreignId('project_id')->nullable()->constrained('projects');
            $table->foreignId('item_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['item_id']);
        });

        Schema::dropIfExists('vouchers');
    }
}
