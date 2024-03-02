<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained(); // Added this line for company_id
            $table->string('name');
            $table->string('project_location');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('manager');
            $table->string('description');
            $table->varchar('garage');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
