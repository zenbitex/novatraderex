<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBlockchainOpt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('blockchain_opt', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id',64)->index();
            $table->string('currency',20);
            $table->integer('user_id')->default(0)->index();
            $table->integer('target_id')->default(0)->index();
            $table->decimal('amount',20,8)->default(0.0);
            $table->tinyInteger('status')->default(0);
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
        //
        Schema::dropIfExists('blockchain_opt');
    }
}
