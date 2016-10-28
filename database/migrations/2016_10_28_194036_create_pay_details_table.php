<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pay_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->integer('gaji_pokok');
            $table->integer('total_uang_makan');
            $table->integer('total_transport');
            $table->integer('total_lembur');
            $table->integer('thr');
            $table->integer('pph21');
            $table->integer('total');
            $table->timestamps();

            $table->foreign('pay_id')
                ->references('id')
                ->on('pays')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('employee_id')
                ->references('id')
                ->on('master_employees')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pay_details');
    }
}
