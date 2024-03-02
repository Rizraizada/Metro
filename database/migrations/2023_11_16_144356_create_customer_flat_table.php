<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerFlatTable extends Migration
{
    public function up()
    {
        Schema::create('customer_flat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('flat_id');
            $table->timestamps();

            // Foreign key relationships
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('flat_id')->references('id')->on('flats')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_flat');
    }
}
