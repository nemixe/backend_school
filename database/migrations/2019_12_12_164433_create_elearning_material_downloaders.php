<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElearningMaterialDownloaders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elearning_material_downloaders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('material_id')->unsigned();
            $table->bigInteger('student_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('elearning_material_downloaders', function (Blueprint $table) {
            $table->foreign('material_id')
                ->references('id')->on('elearning_materials')
                ->onDelete('cascade');
            $table->foreign('student_id')
                ->references('id')->on('elearning_students')
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
        Schema::dropIfExists('elearning_material_downloaders');
    }
}
