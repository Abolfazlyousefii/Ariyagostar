<?php

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOrderingsInProvincesAndCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $provinces         = Province::whereNull('ordering')->get();
        $province_ordering = Province::max('ordering') ?: 1;

        foreach ($provinces as $province) {
            $province->update([
                'ordering' => $province_ordering++
            ]);

            $cities        = City::whereNull('ordering')->where('province_id', $province->id)->get();
            $city_ordering = City::where('province_id', $province->id)->max('ordering') ?: 1;

            foreach ($cities as $city) {
                $city->update([
                    'ordering' => $city_ordering++
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
        //
    }
}
