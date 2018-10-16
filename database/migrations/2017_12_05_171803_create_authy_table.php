<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authy', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->char('country_code',6);
            $table->char('phone_number',11);
            $table->text('authy_id');
            $table->tinyInteger('verified');
            $table->timestamps();
            $table->unique(['country_code', 'phone_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authy');
    }
}
