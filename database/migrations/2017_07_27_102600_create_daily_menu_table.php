<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('food_id')->unsigned();
            $table->integer('quantity');
            $table->timestamps('date');
            $table->foreign('food_id')->references('id')->on('food');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_menu');
    }
}
