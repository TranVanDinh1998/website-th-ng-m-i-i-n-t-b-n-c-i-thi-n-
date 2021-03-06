<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->double('price');
            $table->integer('quantity')->default(0);
            $table->integer('remaining')->default(0);
            $table->integer('rating')->default(0);
            $table->integer('view')->default(0);
            $table->integer('category_id')->nullable()->unsigned();
            $table->integer('producer_id')->nullable()->unsigned();
            $table->integer('discount')->nullable();
            $table->boolean('verified')->default(1);
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
        Schema::dropIfExists('products');
    }
}
