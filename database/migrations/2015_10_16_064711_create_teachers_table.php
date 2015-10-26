<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->string('teid',8);
            $table->primary('teid');
            $table->foreign('teid')->references('uid')->on('myusers');
            $table->string('email',30)->unique();
            $table->string('mphone',11)->unique();
            $table->string('hphone',11);
            $table->string('to',10);
            $table->string('chucvu',20);
            $table->datetime('ngayvaolam')->format(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('teachers');
    }
}
