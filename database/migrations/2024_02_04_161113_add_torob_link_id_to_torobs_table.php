<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTorobLinkIdToTorobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('torobs', function (Blueprint $table) {
            $table->unsignedBigInteger('torob_link_id')->nullable();
            $table->foreign('torob_link_id')->references('id')->on('torob_links')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('torobs', function (Blueprint $table) {
            $table->dropForeign('torobs_torob_link_id_foreign');
            $table->dropColumn('torob_link_id');
        });
    }
}
