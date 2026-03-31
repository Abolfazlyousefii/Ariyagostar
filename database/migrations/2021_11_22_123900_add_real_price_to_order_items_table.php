<?php

use App\Models\OrderItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRealPriceToOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->bigInteger('real_price')->after('price');
        });

        $order_items = OrderItem::select('id', 'price', 'discount')->get();

        foreach ($order_items as $order_item) {
            if ($order_item->discount == 100) {
                $real_price = 0;
            } else {
                $real_price = ($order_item->price * 100) / (100 - $order_item->discount);
            }

            $order_item->update([
                'real_price' => $real_price
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('real_price');
        });
    }
}
