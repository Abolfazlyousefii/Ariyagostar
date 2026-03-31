<?php

use App\Models\Price;
use App\Models\PriceChange;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAvailableToPriceChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_changes', function (Blueprint $table) {
            $table->boolean('is_available')->default(true)->after('product_id');
        });

        $prices = Price::all();

        foreach ($prices as $price) {
            if ($price->stock <= 0) {
                $change = $price->changes()->latest()->first();

                if ($change) {
                    $change->update([
                        'is_available' => false
                    ]);
                } else {
                    PriceChange::create([
                        'product_id' => $price->product_id,
                        'price_id'   => $price->id,
                        'price'      => $price->price,
                        'discount'   => $price->discount
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('price_changes', function (Blueprint $table) {
            $table->dropColumn('is_available');
        });
    }
}
