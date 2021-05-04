<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("cart_id");
            $table->string("transaction_id");
            $table->string("card_details");
            $table->boolean("status")->default(0);
            $table->unsignedBigInteger("created_by");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('cart_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_transactions');
    }
}
