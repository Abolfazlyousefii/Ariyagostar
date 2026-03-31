<?php

use App\Models\Carrier;
use App\Models\Province;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('carrier_id');
            $table->foreign('carrier_id')->references('id')->on('carriers')->onDelete('cascade');

            $table->enum('type', ['within_province', 'extra_province']);
            $table->bigInteger('max_weight');
            $table->bigInteger('shipping_cost');

            $table->timestamps();
        });

        $this->seeder();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tariffs');
    }

    private function seeder()
    {
        $default_province = Province::first();

        if (!$default_province) {
            return;
        }

        $province_id      = option('info_province_id', $default_province->id);
        $city_id          = option('info_city_id', $default_province->cities()->first()->id);

        $carrier = Carrier::create([
            'title'           => 'پست پیشتاز',
            'image'           => '/back/app-assets/images/logo/post-pishtaz.png',
            'description'     => 'ارسال پستی به تمام نقاط کشور',
            'province_id'     => $province_id,
            'city_id'         => $city_id,
            'covered_cities'  => 'all',
            'carrige_forward' => false,
            'is_active'       => true,
        ]);

        $carrier->tariffs()->create([
            'type'            => 'within_province',
            'shipping_cost'   => option('info_shipping_cost', 30000),
            'max_weight'      => 1000000
        ]);

        $carrier->tariffs()->create([
            'type'            => 'extra_province',
            'shipping_cost'   => option('info_shipping_cost', 30000),
            'max_weight'      => 1000000
        ]);

        $carrier = Carrier::create([
            'title'           => 'تیپاکس',
            'image'           => '/back/app-assets/images/logo/tipax.jpg',
            'description'     => 'ارسال با تیپاکس به تمام نقاط کشور',
            'province_id'     => $province_id,
            'city_id'         => $city_id,
            'covered_cities'  => 'all',
            'carrige_forward' => true,
            'is_active'       => false,
        ]);
    }
}
