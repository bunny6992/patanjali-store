<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->integer('products_count');
            $table->integer('total_qty')->nullable();
            $table->decimal('total', 8, 2);
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('discount_percent', 8, 2)->nullable();
            $table->decimal('grand_total', 8, 2);
            $table->decimal('profit', 8, 2)->nullable();
            $table->string('type');
            $table->decimal('total_cost', 8, 2)->nullable();
            $table->string('payment_mode');
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
        Schema::dropIfExists('sales');
    }
}
