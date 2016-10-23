<?php
\Admin::addMenu([
            'parent_id'=>null,
            'title'=>'Pegawai',
            'controller'=>'#',
            'slug'=>'data-pegawai',
            'order'=>2,
        ],[]);

	\Admin::addMenu([
            'parent_id'=>'data-pegawai',
            'title'=>'Departmen',
            'controller'=>'Admin\Pegawai\CutiController',
            'slug'=>'data-pegawai-cuti',
            'order'=>1,
        ],['index','create','update','delete']);


    \Admin::addMenu([
            'parent_id'=>'data-pegawai',
            'title'=>'Departmen',
            'controller'=>'Admin\Pegawai\CutiController',
            'slug'=>'data-pegawai-cuti',
            'order'=>1,
        ],['index','create','update','delete']);

    \Admin::updateMenu([
            'parent_id'=>'data-pegawai',
            'title'=>'Cuti',
            'controller'=>'Admin\Pegawai\CutiController',
            'slug'=>'data-pegawai-cuti',
            'order'=>1,
        ],['index','create','update','delete']);