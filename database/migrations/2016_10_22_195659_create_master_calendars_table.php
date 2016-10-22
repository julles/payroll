<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_calendars', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('event_name',100);
            $table->enum('type',['libur_nasional','cuti_bersama','even_non_libur']);
            $table->timestamps();
        });

        $datas = [
            'date'=>'2016-12-12',
            'event_name'=>'Maulid Nabi Muhamad SAW',
            'type'=>'libur_nasional',
        ];

        \DB::table('master_calendars')->insert($datas);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('master_calendars');
    }
}
