<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDishMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dish_menu', function (Blueprint $table) {
            $table->bigInteger('dish_id', false, true);
            $table->bigInteger('menu_id', false, true);

            $table->foreign('dish_id')->references('id')->on('dishes')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('menu_id')->references('id')->on('menus')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dish_menu');
    }
}
