<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTrasaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('transactions', function($table) {
            $table->string('refrences_payment')->nullable()->change();
            $table->bigInteger('total_bayar')->nullable()->change();
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
            $table->string('refrences_payment')->change();
            $table->bigInteger('total_bayar')->change();
        });
    }
}
