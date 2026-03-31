<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('type');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->text('response')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms', function (Blueprint $table) {
            $table->dropForeign('sms_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('response');
        });
    }
}
