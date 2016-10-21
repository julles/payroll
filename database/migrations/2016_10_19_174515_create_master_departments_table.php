<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('department',100);
            $table->timestamps();
        });

        $datas = [
            [
                'id'=>1,
                'department'=>'IT',
            ],
            [
                'id'=>2,
                'department'=>'HRD',
            ],
        ];

        \DB::table('master_departments')->insert($datas);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('master_departments');
    }
}
