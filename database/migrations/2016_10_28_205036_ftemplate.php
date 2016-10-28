<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ftemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::drop('finger_template');
        // Schema::table('finger_template', function (Blueprint $table) {
        //    \DB::statment("CREATE TABLE IF NOT EXISTS `finger_template` (
        //       `id` int(1) NOT NULL AUTO_INCREMENT,
        //       `finger` smallint(1) NOT NULL,
        //       `ftemplate` longblob NOT NULL,
        //       `employee_id` varchar(11) NOT NULL,
        //       PRIMARY KEY (`id`,`finger`)
        //     ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
        //     ");
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finger_template', function (Blueprint $table) {
            //
        });
    }
}
