<?php

use App\Models\Price;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddDiscountPriceToPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->bigInteger('discount_price')->nullable()->after('discount');
        });

        $prices = Price::withTrashed()->get();

        foreach ($prices as $price) {
            $price->discount_price = $price->price - ($price->price * ($price->discount / 100));
            $price->timestamps = false;
            $price->save();
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
            $table->dropColumn('discount_price');
        });
    }
}
