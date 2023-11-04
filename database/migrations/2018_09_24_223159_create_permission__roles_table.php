<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission__roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permission_id')->unsigned();
            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->boolean('c');
            $table->boolean('r');
            $table->boolean('u');
            $table->boolean('d');
            $table->boolean('admin');
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
        Schema::dropIfExists('permission__roles');
    }
}
