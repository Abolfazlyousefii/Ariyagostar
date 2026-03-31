<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModifyNamespacesInMorphDatabase extends Migration
{
    public $tables = [
        'filterables'         => 'filterable_type',
        'galleries'           => 'galleryable_type',
        'notifications'       => 'notifiable_type',
        'push_subscriptions'  => 'subscribable_type',
        'taggables'           => 'taggable_type',
        'transactions'        => 'transactionable_type',
        'commentable'         => 'commentable_type',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $table_name => $column) {
            if (Schema::hasTable($table_name)) {
                if (Schema::hasColumn($table_name, $column)) {

                    $records = DB::table($table_name)->get();

                    foreach ($records as $record) {
                        DB::table($table_name)->where('id', $record->id)->update([
                            $column => str_replace("App", "App\Models", $record->$column),
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $table_name => $column) {
            if (Schema::hasTable($table_name)) {
                if (Schema::hasColumn($table_name, $column)) {

                    $records = DB::table($table_name)->get();

                    foreach ($records as $record) {
                        DB::table($table_name)->where('id', $record->id)->update([
                            $column => str_replace("App\Models", "App", $record->$column),
                        ]);
                    }
                }
            }
        }
    }
}
