<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransactionPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('transaksi_payments', function($table) {
           // $table->dropColumn('payment_method');
           // $table->dropColumn('total_bayar');
            //$table->dropColumn('refrences_payment');
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
        Schema::table('transaksi_payments', function(BluePrint $table) {
           // $table->string('payment_method');
           // $table->bigInteger('total_bayar');
            //$table->bigInteger('refrences_payment');
        });
    }
}
