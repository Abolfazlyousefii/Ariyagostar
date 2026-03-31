<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilterFieldToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->enum('filter_type', ['inherit', 'none', 'filterId'])->default('inherit');
            $table->unsignedBigInteger('filter_id')->nullable();
            $table->foreign('filter_id')->references('id')->on('filters')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign('categories_filter_id_foreign');
            $table->dropColumn('filter_id');
            $table->dropColumn('filter_type');
        });
    }
}
