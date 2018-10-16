<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('open',32);
            $table->string('low',32);
            $table->string('high',32);
            $table->string('close',32);
            $table->string('average',32);
            $table->string('volume',32);
            $table->timestamp('created_at');
            $table->smallInteger('gap')->index();
            $table->tinyInteger('market_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charts');
    }
}
