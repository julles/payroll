<?php
\Admin::addMenu([
            'parent_id'=>null,
            'title'=>'Master Data',
            'controller'=>'#',
            'slug'=>'master-data',
            'order'=>1,
        ],[]);

		
		\Admin::addMenu([
            'parent_id'=>'master-data',
            'title'=>'Departmen',
            'controller'=>'Admin\MasterData\DepartmenController',
            'slug'=>'departmen',
            'order'=>1,
        ],['index','create','update','delete']);

        \Admin::updateMenu([
            'parent_id'=>'master-data',	
            'title'=>'Departemen',
            'controller'=>'Admin\MasterData\DepartemenController',
            'slug'=>'departmen',
            'order'=>1,
        ],['index','create','update','delete']);

        \Admin::addMenu([
            'parent_id'=>'master-data',
            'title'=>'Jabatan',
            'controller'=>'Admin\MasterData\JabatanController',
            'slug'=>'jabatan',
            'order'=>2,
        ],['index','create','update','delete']);

        \Admin::addMenu([
            'parent_id'=>'master-data',
            'title'=>'Pegawai',
            'controller'=>'Admin\MasterData\PegawaiController',
            'slug'=>'pegawai',
            'order'=>3,
        ],['index','create','update','delete','view']);

        \Admin::addMenu([
            'parent_id'=>'master-data',
            'title'=>'Kalender',
            'controller'=>'Admin\MasterData\KalenderController',
            'slug'=>'kalender',
            'order'=>4,
        ],['index','create','update','delete']);

        \Admin::addMenu([
            'parent_id'=>'master-data',
            'title'=>'Kalender THR',
            'controller'=>'Admin\MasterData\ThrController',
            'slug'=>'kalender-thr',
            'order'=>5,
        ],['index','create','update','delete']);