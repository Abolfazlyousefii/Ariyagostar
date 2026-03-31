<?php

use App\Models\Carrier;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddCarrierIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('carrier_id')->nullable()->after('postal_code');
            $table->foreign('carrier_id')->references('id')->on('carriers')->onDelete('set null');
        });

        $carrier = Carrier::find(1);

        if ($carrier) {
            DB::table('orders')->update([
                'carrier_id' => $carrier->id
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_carrier_id_foreign');
            $table->dropColumn('carrier_id');
        });
    }
}
