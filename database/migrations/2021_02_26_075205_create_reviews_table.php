<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->text('summary');
            $table->integer('product_id')->nullable()->unsigned();
            $table->integer('price_rate');
            $table->integer('value_rate');
            $table->integer('quality_rate');
            $table->integer('user_id')->nullable()->unsigned();
            $table->boolean('verified');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
