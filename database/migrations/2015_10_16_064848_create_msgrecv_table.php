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
            $table->integer('id');
            $table->foreign('id')->references('id')->on('messages');
            $table->string('recvby',8);
            $table->foreign('recvby')->references('id')->on('users');
            $table->integer('isdelete');
            $table->primary(['id','recvby']);

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
