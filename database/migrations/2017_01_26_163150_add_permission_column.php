<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermissionColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table('permissions',function(Blueprint $table){
            $table->string('icon');
            $table->integer('parent');   
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
        Schema::table('permissions',function(Blueprint $table){
            
            $table->dropColumn('icon');
            $table->dropColumn('parent');   
        });
    }
}
