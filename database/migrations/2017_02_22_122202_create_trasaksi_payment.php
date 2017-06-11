<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrasaksiPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('transaksi_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id');
            $table->bigInteger('discount');
            $table->bigInteger('total');
            $table->string('payment_method');
            $table->string('refrences_payment');
            $table->softdeletes();
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
        //
        Schema::drop('transaksi_payments');
    }
}
