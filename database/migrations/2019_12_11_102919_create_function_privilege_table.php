<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunctionPrivilegeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('function_privilege', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('function_id')->unsigned()->nullable();
            $table->bigInteger('privilege_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('function_privilege', function (Blueprint $table) {
            $table->foreign('function_id')
                ->references('id')->on('functions')
                ->onDelete('cascade');
            $table->foreign('privilege_id')
                ->references('id')->on('privileges')
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
        Schema::dropIfExists('function_privilege');
    }
}
