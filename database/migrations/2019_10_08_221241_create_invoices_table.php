<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('products_count');
            $table->integer('total_qty');
            $table->decimal('total', 8, 2);
            $table->decimal('discount', 8, 2);
            $table->decimal('discount_percent', 3, 2);
            $table->decimal('grand_total', 8, 2);
            $table->decimal('profit', 8, 2);
            $table->string('type');
            $table->decimal('avg_cost', 8, 2);
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
        Schema::dropIfExists('invoices');
    }
}
