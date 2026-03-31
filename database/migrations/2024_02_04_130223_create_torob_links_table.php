<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTorobLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('torob_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('torob_id');
            $table->foreign('torob_id')->references('id')->on('torobs')->cascadeOnDelete();
            $table->text('link');
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
        Schema::dropIfExists('torob_links');
    }
}
