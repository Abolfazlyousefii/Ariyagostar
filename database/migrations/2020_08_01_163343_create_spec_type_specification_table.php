<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecTypeSpecificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spec_type_specification', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('specification_id');
            $table->foreign('specification_id')->references('id')->on('specifications')->onDelete('cascade');

            $table->unsignedBigInteger('specification_group_id');
            $table->foreign('specification_group_id')->references('id')->on('specification_groups')->onDelete('cascade');

            $table->unsignedBigInteger('spec_type_id');
            $table->foreign('spec_type_id')->references('id')->on('spec_types')->onDelete('cascade');

            $table->integer('group_ordering')->nullable();
            $table->integer('specification_ordering')->nullable();
            
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
        Schema::dropIfExists('spec_type_specification');
    }
}
