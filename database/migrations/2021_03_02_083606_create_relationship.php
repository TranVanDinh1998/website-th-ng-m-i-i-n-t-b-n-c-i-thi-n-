<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('products')) {
            Schema::table('advertises', function (Blueprint $table) {
                $table->foreign('product_id')->references('id')->on('products');
            });
            Schema::table('collection_products', function (Blueprint $table) {
                $table->foreign('product_id')->references('id')->on('products');
            });
            Schema::table('product_images', function (Blueprint $table) {
                $table->foreign('product_id')->references('id')->on('products');
            });
            Schema::table('reviews', function (Blueprint $table) {
                $table->foreign('product_id')->references('id')->on('products');
            });
            Schema::table('tag_products', function (Blueprint $table) {
                $table->foreign('product_id')->references('id')->on('products');
            });
            Schema::table('wish_lists', function (Blueprint $table) {
                $table->foreign('product_id')->references('id')->on('products');
            });
            Schema::table('order_details', function (Blueprint $table) {
                $table->foreign('product_id')->references('id')->on('products');
            });
        }
        if (Schema::hasTable('categories')) {
            Schema::table('collections', function (Blueprint $table) {
                $table->foreign('category_id')->references('id')->on('categories');
            });
            Schema::table('products', function (Blueprint $table) {
                $table->foreign('category_id')->references('id')->on('categories');
            });
        }
        if (Schema::hasTable('collections')) {
            Schema::table('collection_products', function (Blueprint $table) {
                $table->foreign('collection_id')->references('id')->on('collections');
            });
        }
        if (Schema::hasTable('orders')) {
            Schema::table('order_details', function (Blueprint $table) {
                $table->foreign('order_id')->references('id')->on('orders');
            });
            Schema::table('shipping_addresses', function (Blueprint $table) {
                $table->foreign('order_id')->references('id')->on('orders');
            });
        }
        if (Schema::hasTable('producers')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreign('producer_id')->references('id')->on('producers');
            });
        }
        if (Schema::hasTable('tags')) {
            Schema::table('tag_products', function (Blueprint $table) {
                $table->foreign('tag_id')->references('id')->on('tags');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
