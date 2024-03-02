<?php
// database/migrations/2023_12_01_151332_create_banks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id(); // Auto-incremental primary key
             $table->string('bank_name');
            $table->string('branch_no');
            $table->decimal('opening_balance', 15, 2); // Changed to decimal type
            $table->decimal('deposit', 15, 2); // Changed to decimal type
            $table->decimal('withdraw', 15, 2); // Changed to decimal type
            $table->string('owner');
            $table->string('details'); // Corrected line
            $table->timestamps(); // Created_at and Updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('banks');
    }
}


