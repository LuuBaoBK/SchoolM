<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhancongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("phancong", function(Blueprint $table){
            $table->string("teacher_id", 9);
            $table->string("class_id", 11);
            $table->primary(array("teacher_id", "class_id"));
            $table->foreign("teacher_id")->references("id")->on("teachers");
            $table->foreign("class_id")->references("id")->on("classes");    
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop("phancong");
    }
}
