<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsgrecvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msgrecv', function (Blueprint $table) {
            $table->integer('mrid');
            $table->foreign('mrid')->references('mid')->on('messages');
            $table->string('recvby',8);
            $table->foreign('recvby')->references('uid')->on('myusers');
            $table->integer('isdelete');
            $table->primary(['mrid','recvby']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('msgrecv');
    }
}
