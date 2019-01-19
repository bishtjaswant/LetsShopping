<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
             $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('descriptions');
            $table->boolean('featured')->default(0);
            $table->double('price');
            $table->integer('discount_price');
            $table->text('thumbnail');
            $table->text('options')->nullable();

            $table->timestamps();
            $table->softDeletes();


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
