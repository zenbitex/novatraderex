<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXchangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xchange', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->tinyInteger('market_id')->index();
            $table->tinyInteger('type')->index();
            $table->decimal('volume',20,8);
            $table->decimal('rvolume',20,8);
            $table->decimal('price',20,8);
            $table->decimal('fee',20,8);
            $table->tinyInteger('status');
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
        Schema::dropIfExists('xchange');
    }
}
