<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizeTypeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('size_type_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('size_type_id');
            $table->foreign('size_type_id')->references('id')->on('size_types')->cascadeOnDelete();

            $table->unsignedBigInteger('size_id');
            $table->foreign('size_id')->references('id')->on('sizes')->cascadeOnDelete();

            $table->string('value')->nullable();
            $table->integer('group');
            $table->integer('ordering')->nullable();

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
        Schema::dropIfExists('size_type_values');
    }
}
