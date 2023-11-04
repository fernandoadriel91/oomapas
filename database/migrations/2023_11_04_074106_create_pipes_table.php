<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pipes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('telephone')->nullable();
            $table->string('address');
            $table->string('contract')->nullable();
            $table->string('folio')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('active');
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('pipes');
    }
}
