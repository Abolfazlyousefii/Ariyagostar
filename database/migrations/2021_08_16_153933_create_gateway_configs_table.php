<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatewayConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gateway_configs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('gateway_id');
            $table->foreign('gateway_id')->references('id')->on('gateways')->onDelete('cascade');

            $table->string('key');
            $table->string('value')->nullable();

            $table->unique(['gateway_id', 'key']);
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
        Schema::dropIfExists('gateway_configs');
    }
}
