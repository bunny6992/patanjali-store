<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sales_id');
            $table->integer('product_id');
            $table->integer('batch_id');
            $table->string('name');
            $table->integer('mrp');
            $table->integer('qty');
            $table->decimal('avg_cost', 8, 2);
            $table->decimal('row_total', 8, 2);
            $table->string('type');
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
        Schema::dropIfExists('sales_items');
    }
}
