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
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('title_en')->nullable();
            $table->string('type');
            
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

            $table->unsignedBigInteger('spec_type_id')->nullable();
            $table->foreign('spec_type_id')->references('id')->on('spec_types')->onDelete('set null');

            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->bigInteger('price')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('stock')->nullable();
            $table->boolean('special')->default(false);
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->unsignedBigInteger('sell')->default(0);
            $table->unsignedBigInteger('view')->default(0);
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
        Schema::dropIfExists('products');
    }
}
