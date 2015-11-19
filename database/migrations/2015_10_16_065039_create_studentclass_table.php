
<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentclassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentclass', function (Blueprint $table) {
            $table->string('class_id',11);
            $table->string('student_id',9);
            $table->string('conduct');
            $table->integer('ispassed');
            $table->string('note');
            $table->primary(array('class_id','student_id'));
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('student_id')->references('id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('studentclass');
    }
}
