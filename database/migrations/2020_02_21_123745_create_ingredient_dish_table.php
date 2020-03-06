<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientDishTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dish_ingredient', function (Blueprint $table) {
            $table->bigInteger('ingredient_id', false, true);
            $table->bigInteger('dish_id', false, true);
            $table->integer('quantity');
            $table->boolean('is_necessary');

            $table->foreign('ingredient_id')->references('id')->on('ingredients')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('dish_id')->references('id')->on('dishes')
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
        Schema::dropIfExists('ingredient_dish');
    }
}
