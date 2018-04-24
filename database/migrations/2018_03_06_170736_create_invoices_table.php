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
            $table->integer('salesid')->index()->unsigned();
            $table->integer('productid')->index()->unsigned();
            $table->foreign('salesid')->references('id')->on('sales')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('productid')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
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
