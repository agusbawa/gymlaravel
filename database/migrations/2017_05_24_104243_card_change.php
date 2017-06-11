<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CardChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('cards', function (Blueprint $table) {
           $table->renameColumn('start','awal');
           $table->renameColumn('end','akhir');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('cards', function (Blueprint $table) {
           $table->renameColumn('awal','start');
           $table->renameColumn('akhir','end');
       });
    }
}
