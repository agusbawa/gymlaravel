<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('transactions', function (Blueprint $table) {
           
            
            $table->dropColumn('discount');
            $table->dropColumn('total');
            $table->dropColumn('payment_method');
            $table->dropColumn('refrences_payment');
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
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('transaction_id');
            $table->bigInteger('discount');
            $table->bigInteger('total');
            $table->string('payment_method');
            $table->string('refrences_payment');
        });
    }
}
