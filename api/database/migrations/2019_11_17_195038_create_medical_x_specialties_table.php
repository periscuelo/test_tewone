<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalXSpecialtiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_x_specialties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_medical');
            $table->unsignedInteger('id_specialty');
            $table->timestamps();
            $table->unique(array('id_medical', 'id_specialty'));
            $table->foreign('id_medical')
                  ->references('id')
                  ->on('medical')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
            $table->foreign('id_specialty')
                  ->references('id')
                  ->on('specialties')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_x_specialties');
    }
}
