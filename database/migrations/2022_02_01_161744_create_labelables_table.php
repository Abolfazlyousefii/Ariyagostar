<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labelables', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('label_id');
            $table->foreign('label_id')->references('id')->on('labels')->onDelete('cascade');

            $table->string('labelable_type');
            $table->unsignedBigInteger('labelable_id');
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
        Schema::dropIfExists('labelables');
    }
}
