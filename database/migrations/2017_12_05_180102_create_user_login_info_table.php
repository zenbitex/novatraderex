<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLoginInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_login_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('login_ip',45);
            $table->string('last_login_ip',45);
            $table->dateTime('login_time');
            $table->dateTime('last_login_time');
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
        Schema::dropIfExists('user_login_info');
    }
}
