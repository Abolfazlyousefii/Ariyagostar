<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RemoveLinkGroupIdFromLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('link_groups')) {
            $groups = DB::table('link_groups')->get();

            foreach ($groups as $group) {
                option_update('link_groups_' . $group->id, $group->title);
            }

            Schema::disableForeignKeyConstraints();
            Schema::dropIfExists('link_groups');
            Schema::enableForeignKeyConstraints();


            Schema::table('links', function (Blueprint $table) {
                $table->dropForeign('links_link_group_id_foreign');
            });
        }
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
