<?php

use App\Models\Price;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegularPriceToPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->bigInteger('regular_price')->after('discount_price');
        });

        foreach (Price::with('product:id,currency_id,rounding_amount,rounding_type')->withTrashed()->get() as $price) {
            $price->update([
                'regular_price' => get_discount_price($price->price, 0, $price->product)
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
        Schema::table('prices', function (Blueprint $table) {
            $table->dropColumn('regular_price');
        });
    }
}
