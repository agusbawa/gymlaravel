<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('cards', function(Blueprint $table) {
            $table->integer('start');
            $table->integer('interval');
            $table->integer('end');
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
        Schema::table('cards', function(Blueprint $table) {
            $table->dropColumn('start');
            $table->dropColumn('interval');
            $table->dropColumn('end');
        });
    }
}
