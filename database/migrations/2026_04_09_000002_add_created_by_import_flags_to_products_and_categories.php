<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByImportFlagsToProductsAndCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('created_by_import')->default(false)->after('external_product_id');
            $table->index('created_by_import');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('created_by_import')->default(false)->after('published');
            $table->index('created_by_import');
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
            $table->dropIndex(['created_by_import']);
            $table->dropColumn('created_by_import');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['created_by_import']);
            $table->dropColumn('created_by_import');
        });
    }
}
