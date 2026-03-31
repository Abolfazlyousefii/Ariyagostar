<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RemoveSinglePriceFromProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $products = Product::where('price_type', 'single-price')->get();

        foreach ($products as $product) {

            $price = $product->prices()->create(
                [
                    "price"       => $product->price,
                    "discount"    => $product->discount,
                    "stock"       => $product->stock,
                    "cart_max"    => $product->cart_max,
                    "cart_min"    => $product->cart_min,
                ]
            );

            $product->update([
                'price_type' => 'multiple-price'
            ]);

            DB::table('cart_product')->where('product_id', $product->id)->update([
                'price_id' => $price->id
            ]);

            DB::table('price_changes')->where('product_id', $product->id)->update([
                'price_id' => $price->id
            ]);

            DB::table('order_items')->where('product_id', $product->id)->update([
                'price_id' => $price->id
            ]);
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('discount');
            $table->dropColumn('stock');
            $table->dropColumn('cart_max');
            $table->dropColumn('cart_min');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('price')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('stock')->nullable();
            $table->integer('cart_max')->nullable();
            $table->integer('cart_min')->nullable();
        });
    }
}
