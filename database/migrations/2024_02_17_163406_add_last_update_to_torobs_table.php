<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastUpdateToTorobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('torobs', function (Blueprint $table) {
            $table->timestamp('last_update')->nullable()->after('is_merged');
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
            $table->dropColumn('last_update');
        });
    }
}
