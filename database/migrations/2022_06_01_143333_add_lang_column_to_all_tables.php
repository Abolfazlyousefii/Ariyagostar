<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddLangColumnToAllTables extends Migration
{
    private $tables = [
        'attribute_groups'       => 'ordering',
        'banners'                => 'ordering',
        'brands'                 => 'description',
        'carriers'               => 'title',
        'categories'             => 'title',
        'cities'                 => 'name',
        'contacts'               => 'name',
        'discounts'              => 'title',
        'labels'                 => 'title',
        'links'                  => 'title',
        'menus'                  => 'type',
        'options'                => 'option_value',
        'pages'                  => 'title',
        'posts'                  => 'title',
        'products'               => 'title',
        'provinces'              => 'name',
        'sliders'                => 'title',
        'specifications'         => 'name',
        'specification_groups'   => 'name',
        'spec_types'             => 'name',
        'static_filters'         => 'title',
        'tags'                   => 'name',
        'viewers'                => 'ip',
        'widgets'                => 'title',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $item => $after_column) {
            if (!Schema::hasColumn($item, 'lang')) {
                Schema::table($item, function (Blueprint $table) use ($after_column) {
                    $table->string('lang', 30)->default('fa')->after($after_column);
                });
            }

            DB::table($item)->update([
                'lang' => 'fa'
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $item) {
            if (Schema::hasColumn($item, 'lang')) {
                Schema::table($item, function (Blueprint $table) {
                    $table->dropColumn('lang');
                });
            }
        }
    }
}
