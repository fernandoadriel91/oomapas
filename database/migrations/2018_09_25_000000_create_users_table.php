<?php

use Illuminate\Support\Facades\Schema;
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
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email');
            $table->string('dependency_id', 4);
            $table->foreign('dependency_id')->references('id')->on('dependencies');
            $table->string('department_id', 4);
            $table->foreign('department_id')->references('id')->on('departments');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('password');
            $table->boolean('active');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
