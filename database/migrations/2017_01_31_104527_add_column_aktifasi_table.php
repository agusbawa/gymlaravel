<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAktifasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('aktifasis', function(Blueprint $table) {
            $table->integer('gym_id');
            $table->integer('package_id');
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
        Schema::table('aktifasis', function(Blueprint $table) {
            $table->dropColumn('gym_id');
            $table->dropColumn('package_id');
        });
    }
}
