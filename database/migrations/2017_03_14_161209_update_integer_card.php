<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIntegerCard extends Migration
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
            $table->bigInteger('start')->change();
            $table->bigInteger('end')->change();
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
            $table->integer('start')->change();
            $table->integer('end')->change();
        });
    }
}
