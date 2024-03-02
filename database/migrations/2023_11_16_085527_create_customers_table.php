<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->unsignedBigInteger('assigned_company');
            $table->varchar('installment');
            $table->varchar('total_installment');
            $table->varchar('garage');
            $table->varchar('car_money');
             $table->varchar('utility_charge');

            $table->varchar('special_discount');
            $table->varchar('tiles_charge');
            $table->varchar('other_charge');



            $table->text('details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
