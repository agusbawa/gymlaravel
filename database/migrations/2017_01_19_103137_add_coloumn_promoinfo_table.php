<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnPromoinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('promo_info', function(Blueprint $table) {
            $table->date('harimulai');
            $table->date('hariakhir');
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
        Schema::table('promo_info', function(Blueprint $table) {
            $table->dropColumn('harimulai');
            $table->dropColumn('hariakhir');
        });
    }
}
