<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsMergedToTorobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('torobs', function (Blueprint $table) {
            $table->boolean('is_merged')->default(false)->after('check_torob');
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
            $table->dropColumn('is_merged');
        });
    }
}
