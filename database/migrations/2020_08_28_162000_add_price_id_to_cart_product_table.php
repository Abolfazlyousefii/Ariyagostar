<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceIdToCartProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_product', function (Blueprint $table) {
            $table->unsignedBigInteger('price_id')->nullable();
            $table->foreign('price_id')->references('id')->on('prices')->onDelete('cascade');
            
            $table->unique(['cart_id', 'product_id', 'price_id']);
            $table->dropUnique("cart_product_cart_id_product_id_unique");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_product', function (Blueprint $table) {
            $table->unique(['cart_id', 'product_id']);
            $table->dropForeign('cart_product_price_id_foreign');
            $table->dropUnique("cart_product_cart_id_product_id_price_id_unique");
            $table->dropColumn('price_id');
        });
    }
}
