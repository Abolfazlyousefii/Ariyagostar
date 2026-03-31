<?php

use App\Models\Attribute;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderingToAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->integer('ordering')->nullable()->after('value');
        });

        $attributes_group = Attribute::orderBy('name')->get();

        foreach ($attributes_group->groupBy('attribute_group_id') as $group) {
            $i = 0;

            foreach ($group as $attr) {
                $attr->update([
                    'ordering' => $i++
                ]);
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
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropColumn('ordering');
        });
    }
}
