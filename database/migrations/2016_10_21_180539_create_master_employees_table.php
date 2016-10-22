<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('position_id')->unsigned();
            $table->string('nip',10);
            $table->string('name',40);
            $table->enum('gender',['w','m']);
            $table->enum('status',['lajang','menikah','duda','janda'])->default('lajang');
            $table->string('place_of_birth',30);
            $table->date('date_of_birth');
            $table->text('address');
            $table->string('postal_code',8);
            $table->string('phone',15);
            $table->enum('religion',['islam','kristen','katolik','budha','hindu','konghucu']);
            $table->string('number_id',20);
            $table->string('foto',50)->nullable();
            $table->string('email',50);
            $table->date('join_date',50);
            $table->integer('basic_salary');
            $table->integer('meal_allowance');
            $table->integer('transport');
            $table->integer('overtime');
            $table->binary('finger_id')->nullable();
            $table->timestamps();

            $table->foreign('position_id')
                ->references('id')
                ->on('master_positions')
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
        Schema::drop('master_employees');
    }
}
