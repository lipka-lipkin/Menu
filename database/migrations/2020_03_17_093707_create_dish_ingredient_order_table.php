<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDishIngredientOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dish_ingredient_order', function (Blueprint $table) {
            $table->bigInteger('dish_id', false, true);
            $table->bigInteger('order_id', false, true);
            $table->bigInteger('ingredient_id', false, true);
            $table->decimal('amount', 4, 2);

            $table->foreign('dish_id')->references('id')->on('dishes')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('order_id')->references('id')->on('orders')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('ingredient_id')->references('id')->on('ingredients')
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
        Schema::dropIfExists('dish_ingredient_order');
    }
}
