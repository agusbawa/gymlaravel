<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status')->nullable();
            $table->string('name')->nullable();
            $table->double('individual_bonus')->default(0)->nullable();
            $table->double('group_bonus')->default(0)->nullable();
            $table->double('overriding_bonus')->default(0)->nullable();
            $table->double('honeymoon_bonus')->default(0)->nullable();
            $table->string('reward_bonus')->nullable();
            $table->double('individual_target')->default(0)->nullable();
            $table->double('group_target')->default(0)->nullable();
            $table->double('reward_target')->default(0)->nullable();
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
        Schema::dropIfExists('user_types');
    }
}
