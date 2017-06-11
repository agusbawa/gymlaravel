<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTargetGtm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('target_gym', function(Blueprint $table) {
            $table->dropColumn('extends_per_month');
            $table->dropColumn('extends_per_month_price');
            $table->dropColumn('returner_price');
            $table->dropColumn('new_member');
            $table->dropColumn('harian');
            $table->dropColumn('personal_trainer_id');
            $table->dropColumn('total');
            $table->dropColumn('kantin');
            $table->string('year');    

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
    }
}
