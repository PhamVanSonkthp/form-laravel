<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('category_id')->default(0);
            $table->text('slug');
            $table->bigInteger('price_import');
            $table->bigInteger('price_client');
            $table->bigInteger('price_agent');
            $table->bigInteger('inventory')->default(0);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('products');
    }
}
