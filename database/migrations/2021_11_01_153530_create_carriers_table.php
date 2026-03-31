<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carriers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image')->nullable();
            $table->string('waiting_time')->nullable();
            $table->bigInteger('max_package_weight')->nullable();
            $table->bigInteger('min_package_weight')->nullable();
            $table->bigInteger('extra_cost')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();

            $table->unsignedBigInteger('province_id');
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');

            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->bigInteger('free_shipping_weight')->nullable();
            $table->bigInteger('free_shipping_price')->nullable();
            $table->boolean('carrige_forward')->default(false);

            $table->enum('covered_cities', ['all', 'select_city'])->default('all');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carriers');
    }
}
