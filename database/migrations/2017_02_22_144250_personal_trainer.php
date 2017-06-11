<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PersonalTrainer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('personal_trainer', function(Blueprint $table) {
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
         Schema::table('personal_trainer', function(Blueprint $table) {
            $table->dropColumn('tgl_bayar');
            $table->dropColumn('payment_method');
        });
    }
}
