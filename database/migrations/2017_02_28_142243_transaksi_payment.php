<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransaksiPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('transactions', function(Blueprint $table) {
            $table->string('payment_method');
            $table->bigInteger('total_bayar');
            $table->string('refrences_payment');
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
        Schema::table('transactions', function($table) {
            $table->dropColumn('payment_method');
            $table->dropColumn('total_bayar');
            $table->dropColumn('refrences_payment');
        });
    }
}
