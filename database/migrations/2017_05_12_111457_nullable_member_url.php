<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableMemberUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        
        Schema::table('members', function($table) {
            //
            $table->string('facebook_url', 255)->nullable()->change();
			$table->string('twitter_url', 255)->nullable()->change();
			$table->string('instagram_url', 255)->nullable()->change();
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
         Schema::table('members', function($table) {
            //
            $table->string('facebook_url', 255)->change();
			$table->string('twitter_url', 255)->change();
			$table->string('instagram_url', 255)->change();
        });
    }
}
