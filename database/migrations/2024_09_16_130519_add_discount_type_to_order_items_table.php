<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountTypeToOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('discount_type')->default('percent')->after('discount')->comment('percent|fixed');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('in_person')->default(false)->after('by_admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('discount_type');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('in_person');
        });
    }
}
