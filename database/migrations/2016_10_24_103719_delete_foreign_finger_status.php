<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteForeignFingerStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finger_status', function (Blueprint $table) {
            $table->dropForeign('finger_status_employee_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finger_status', function (Blueprint $table) {
            $table->foreign('employee_id')
                ->references('id')
                ->on('master_employees')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
}
