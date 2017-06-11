<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePengeluaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('pengeluaran', function(Blueprint $table) {
            $table->date('tgl_keluar');
            $table->text('deskripsi');
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
        Schema::table('pengeluaran', function(Blueprint $table) {
            $table->dropColumn('tgl_keluar');
            $table->dropColumn('deskripsi');
        });
    }
}
