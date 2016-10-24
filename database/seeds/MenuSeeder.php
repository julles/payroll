<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        include database_path('seeds/menu/common.php');
        include database_path('seeds/menu/master_data.php');
        include database_path('seeds/menu/pegawai.php');
        include database_path('seeds/menu/approval.php');
    }
}
