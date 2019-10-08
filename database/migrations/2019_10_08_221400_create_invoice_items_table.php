<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('invoice_id');
            $table->integer('product_id');
            $table->integer('batch_id');
            $table->bigInteger('barcode');
            $table->integer('tax');
            $table->integer('mrp');
            $table->integer('qty');
            $table->decimal('avg_cost', 8, 2);
            $table->integer('total');
            $table->decimal('discount', 8, 2);
            $table->decimal('discount_percent', 3, 2);
            $table->decimal('row_total', 8, 2);
            $table->decimal('profit', 8, 2);
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
        Schema::dropIfExists('invoice_items');
    }
}
