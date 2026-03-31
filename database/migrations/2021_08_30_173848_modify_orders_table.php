<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_province_id_foreign');
            $table->dropForeign('orders_city_id_foreign');

            $table->string('postal_code')->nullable()->change();
            $table->text('address')->nullable()->change();

            $table->unsignedBigInteger('province_id')->nullable()->change();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('set null');

            $table->unsignedBigInteger('city_id')->nullable()->change();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
