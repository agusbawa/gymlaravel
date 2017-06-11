<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrialMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trial_member', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('nick_name', 100);
            $table->string('slug', 100);
            $table->string('address_street', 100);
            $table->string('address_region', 100);
            $table->string('address_city', 100);
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->string('gender', 30);
            $table->string('phone', 15);
            $table->date('folow_up');
            $table->string('folow_up_by', 100);
            $table->date('tanggal_kedatangan');
            $table->enum('status', ['datang', 'tidakdatang']);
            $table->longText('remark');
            $table->bigInteger('gym_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trial_member');
    }
}
