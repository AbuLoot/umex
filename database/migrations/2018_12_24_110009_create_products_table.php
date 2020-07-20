<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('sort_id');
            $table->integer('company_id');
            $table->string('barcode');
            $table->integer('count');
            $table->integer('condition')->default(1); // Состояние
            $table->string('area')->nullable();
            $table->string('capacity')->nullable();
            $table->string('weight')->nullable();
            $table->text('image')->nullable();
            $table->text('images')->nullable();
            $table->char('path', 50);
            $table->integer('mode')->default(0);
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('products_lang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('slug');
            $table->string('title');
            $table->string('meta_title');
            $table->string('meta_description')->nullable();
            $table->decimal('price', 44, 2);
            $table->decimal('price_total', 44, 2);
            $table->text('description');
            $table->text('characteristic')->nullable();
            $table->char('lang', 4);
            $table->integer('views')->default(0);
            $table->timestamps();
        });

        Schema::create('product_category', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->primary(['product_id', 'category_id']);
        });

        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id')->nullable();
            $table->string('slug');
            $table->string('title');
            $table->string('data');
            $table->string('lang');
            $table->timestamps();
        });

        Schema::create('product_option', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->integer('option_id')->unsigned();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');

            $table->primary(['product_id', 'option_id']);
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
