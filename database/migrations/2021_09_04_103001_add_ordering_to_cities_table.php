<?php

use App\Models\Province;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderingToCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->integer('ordering')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
        });

        foreach (Province::all() as $province) {
            $ordering = 1;

            foreach ($province->cities as $city) {
                $city->update([
                    'ordering' => $ordering++
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
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('ordering');
            $table->dropColumn('is_active');
            $table->dropSoftDeletes();
        });
    }
}
