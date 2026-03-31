<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code')->unique();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->enum('type', ['amount', 'percent']);
            $table->decimal('amount', 15);
            $table->integer('discount_ceiling')->nullable();
            $table->bigInteger('least_price')->nullable();
            $table->integer('least_products_count')->nullable();
            $table->text('description')->nullable();
            $table->boolean('only_first_purchase')->default(false);
            $table->boolean('not_discount_products')->default(false);
            $table->boolean('published')->default(true);
            $table->integer('quantity')->nullable();
            $table->integer('quantity_per_user')->nullable();

            $table->enum('include_type', ['all', 'category', 'product'])->default('all');
            $table->enum('exclude_type', ['none', 'category', 'product'])->default('none');
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
        Schema::dropIfExists('discounts');
    }
}
