<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameMemberHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('member_histories', function (Blueprint $table) {
            $table->renameColumn('packege_price_id','package_price_id');
            $table->dateTime('new_register')->nullable()->change();
            $table->dateTime('extends')->nullable()->change();
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
        Schema::table('member_histories', function (Blueprint $table) {
            $table->renameColumn('package_price_id','packege_price_id');
            $table->dateTime('new_register')->change();
            $table->dateTime('extends')->change();
        });
         
    }
}
