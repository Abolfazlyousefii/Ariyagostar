<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTorobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('torobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();

            $table->bigInteger('min_price')->nullable();
            $table->bigInteger('price')->nullable();
            $table->string('last_price_change')->nullable();
            $table->text('price_link')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('title')->nullable();
            $table->boolean('review_need')->default(false);
            $table->boolean('check_torob')->default(true);

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
        Schema::dropIfExists('torobs');
    }
}
