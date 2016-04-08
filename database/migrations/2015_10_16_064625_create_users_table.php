<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id',9)->primary();
            $table->string('email',80)->unique();
            $table->string('password',60);
            $table->integer('role');
            $table->string('firstname',20);
            $table->string('middlename',20);
            $table->string('lastname',20);
            $table->string('fullname',60);
            $table->date('dateofbirth');
            $table->string('address',120);
            $table->string('gender',1);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
