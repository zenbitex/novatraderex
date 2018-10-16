<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXchangeInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xchange_info', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('market_id')->index();
            $table->integer('user_id')->index();
            $table->tinyInteger('type');
            $table->decimal('last_price',20,8);
            $table->decimal('volume',20,8);
            $table->decimal('fee',20,8);
            $table->integer('created_at');
            $table->integer('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xchange_info');
    }
}
