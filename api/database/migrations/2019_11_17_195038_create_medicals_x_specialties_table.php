<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalsXSpecialtiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicals_x_specialties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_medical');
            $table->unsignedInteger('id_specialty');
            $table->timestamps();
            $table->unique(array('id_medical', 'id_specialty'));
            $table->foreign('id_medical')
                  ->references('id')
                  ->on('medicals')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('id_specialty')
                  ->references('id')
                  ->on('specialties')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicals_x_specialties');
    }
}
