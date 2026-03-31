<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('status');
            $table->bigInteger('amount')->nullable();
            $table->string('transId')->nullable()->unique();
            $table->string('factorNumber')->nullable();
            $table->string('mobile')->nullable();
            $table->text('description')->nullable();
            $table->string('cardNumber')->nullable();
            $table->string('traceNumber')->nullable();
            $table->string('message')->nullable();
            $table->string('token');
            
            $table->unsignedBigInteger('transactionable_id');
            $table->string('transactionable_type');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('transactions');
    }
}
