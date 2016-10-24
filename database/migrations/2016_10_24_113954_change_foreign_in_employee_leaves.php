<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeForeignInEmployeeLeaves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_leaves', function (Blueprint $table) {
            $table->dropForeign('employee_leaves_approve_id_foreign');
            $table->dropForeign('employee_leaves_employee_id_foreign');        
            $table->foreign('employee_id')
                ->references('id')
                ->on('master_employees')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('approve_id')
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
        Schema::table('employee_leaves', function (Blueprint $table) {
            $table->dropForeign('employee_leaves_approve_id_foreign');
            $table->dropForeign('employee_leaves_employee_id_foreign'); 
            $table->foreign('employee_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('approve_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }
}
