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
            $table->string('id',8)->primary();
            $table->string('email',25)->unique();
            $table->string('password',60);
            $table->integer('role');
            $table->string('fullname',30);
            $table->datetime('dateofbirth')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('address',80);
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
