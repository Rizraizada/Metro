<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlatVouchersTable extends Migration
{
    public function up()
    {
        Schema::create('flat_vouchers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->date('month');
            $table->integer('voucher_no');
            $table->string('paid_to');
            $table->string('category');
            $table->foreignId('customer_id')->constrained(); // Assuming you have a customers table
            $table->foreignId('project_id')->constrained(); // Assuming you have a projects table
            $table->foreignId('flat_id')->constrained();    // Assuming you have a flats table
            $table->foreignId('bank_id')->constrained();    // Assuming you have a flats table

            $table->decimal('amount', 15, 2); // Adjust the first parameter (15) to your desired size
            $table->string('description');
            $table->string('delay_charge');
            $table->varchar('car_money');
            $table->varchar('utility_charge');

           $table->varchar('special_discount');
           $table->varchar('tiles_work');
           $table->varchar('refund_money');


           $table->varchar('miscellaneous_cost');

            $table->string('payee');
            $table->string('note');
        });
    }

    public function down()
    {
        Schema::dropIfExists('flat_vouchers');
    }
}
