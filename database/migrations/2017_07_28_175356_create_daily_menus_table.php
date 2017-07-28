<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('food_id')->unsigned()->nullable();
            $table->integer('quantity');
            $table->date('date');
            $table->foreign('food_id')->references('id')->on('foods');
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
        Schema::dropIfExists('daily_menus');
    }
}
