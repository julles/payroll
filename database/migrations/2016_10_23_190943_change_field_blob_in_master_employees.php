<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldBlobInMasterEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_employees', function (Blueprint $table) {
            $table->dropColumn('finger_id');
            \DB::statement("alter table master_employees ADD FTemplate LONGBLOB NULL ");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_employees', function (Blueprint $table) {
            $table->binary('finger_id');
            $table->dropColumn('FTemplate');
        });
    }
}
