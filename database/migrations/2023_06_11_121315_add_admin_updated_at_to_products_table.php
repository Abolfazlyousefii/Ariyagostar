<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminUpdatedAtToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->timestamp('admin_updated_at')->nullable()->after('created_at');
        });

        $products = Product::select('id', 'updated_at', 'created_at', 'admin_updated_at')->get();

        foreach ($products as $product) {
            $product->timestamps = false;
            $product->admin_updated_at = $product->updated_at;
            $product->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('admin_updated_at');
        });
    }
}
