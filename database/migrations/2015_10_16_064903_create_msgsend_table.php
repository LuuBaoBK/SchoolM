<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsgsendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msgsend', function (Blueprint $table) {
            $table->integer('msid');
            $table->string('sendby',8);
            $table->primary('msid');
            $table->foreign('msid')->references('mid')->on('messages');
            $table->foreign('sendby')->references('uid')->on('myusers');
            $table->integer('isdelete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('msgsend');
    }
}
