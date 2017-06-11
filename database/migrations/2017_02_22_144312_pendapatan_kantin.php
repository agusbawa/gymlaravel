<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PendapatanKantin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('kantin', function(Blueprint $table) {
            $table->date('tgl_bayar');
            $table->string('payment_method');
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
         Schema::table('kantin', function(Blueprint $table) {
            $table->dropColumn('tgl_bayar');
            $table->dropColumn('payment_method');
        });
    }
}
