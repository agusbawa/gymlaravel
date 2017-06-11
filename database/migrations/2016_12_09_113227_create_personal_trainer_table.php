    <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalTrainerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_trainer', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name', 100);
                        $table->integer('fee_trainer');
                        $table->integer('fee_gym');
                        $table->bigInteger('gym_id')->unsigned();
			$table->softDeletes();
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
        Schema::drop('personal_trainer');
    }
}
