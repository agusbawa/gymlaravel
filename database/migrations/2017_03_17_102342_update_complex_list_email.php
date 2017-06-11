<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateComplexListEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('list_emails', function(Blueprint $table) {
            $table->integer('usia_min')->nullable();
            $table->integer('usia_max')->nullable();
            $table->date('bulan')->nullable();
            $table->integer('member_baru_paket')->nullable();
            $table->integer('perpanjang_baru_paket')->nullable();
            $table->integer('paket')->nullable();
            $table->integer('gym_harian')->nullable();
            $table->integer('free_tial')->nullable();
            $table->integer('member_belum_aktivais')->nullable();
            $table->integer('member_belum_aktivasi')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('list_emails', function(Blueprint $table) {
            $table->dropColumn('usia_min');
            $table->dropColumn('usia_max');
            $table->dropColumn('bulan');
            $table->dropColumn('member_baru_paket');
            $table->dropColumn('perpanjang_baru_paket');
            $table->dropColumn('paket');
            $table->dropColumn('gym_harian');
            $table->dropColumn('free_tial');
            $table->dropColumn('member_belum_aktivais');
            $table->dropColumn('member_belum_aktivasi');
            
        });
    }
}
