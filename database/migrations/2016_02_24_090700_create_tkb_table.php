<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTkbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("tkb", function(Blueprint $table){
            $table->string("teacher_id",9);
            $table->primary("teacher_id");
            $table->foreign("teacher_id")->references("id")->on("teachers");
            $table->integer("sotietconlai");
            for($i = 0; $i < 50; $i++){
                $table->string('T'.$i ,11);
            }    
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
        Schema::drop("tkb");
    }
}
