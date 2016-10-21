<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department_id')->unsigned();
            $table->string('position',100);
            $table->timestamps();

            $table->foreign('department_id')
                ->references('id')
                ->on('master_departments')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_positions',function(Blueprint $table){
            $table->dropForeign('master_positions_department_id_foreign');
        });
        Schema::drop('master_positions');
    }
}
