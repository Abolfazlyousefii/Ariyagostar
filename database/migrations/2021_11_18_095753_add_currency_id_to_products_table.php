<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('rounding_type', ['default', 'close', 'up', 'down'])->default('default')->after('view');
            $table->enum('rounding_amount', ['default', 'no', '100', '1000', '10000', '100000'])->default('default')->after('rounding_type');
            $table->unsignedBigInteger('currency_id')->nullable()->after('rounding_amount');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('set null');
        });

        Schema::table('prices', function (Blueprint $table) {
            $table->decimal('price', 64, 8)->change();
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
            $table->dropColumn('rounding_type');
            $table->dropColumn('rounding_amount');
            $table->dropForeign('products_currency_id_foreign');
            $table->dropColumn('currency_id');
        });
    }
}
