<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteFieldBlobInEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_employees', function (Blueprint $table) {
            $table->dropColumn('FTemplate');
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
            \DB::statement("alter table master_employees ADD FTemplate LONGBLOB NULL ");
        });
    }
}
