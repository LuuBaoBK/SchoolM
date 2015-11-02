
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
            $table->string('class_id',8);
            $table->string('student_id',8);
            $table->primary(array('class_id','student_id'));
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('student_id')->references('id')->on('students');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
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
