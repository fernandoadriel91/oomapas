<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPasswordExpiresColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('password_expires')->nullable();
            $table->date('last_password_changed')->nullable();
        });
        DB::table('users')->update(array('password_expires' => 1, 'last_password_changed' => \Carbon\Carbon::now()));
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('password_expires')->nullable(false)->change();
            $table->date('last_password_changed')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('password_expires');
            $table->dropColumn('last_password_changed');
        });
    }
}
