a<?php
\Admin::addMenu([
            'parent_id'=>null,
            'title'=>'Approval',
            'controller'=>'#',
            'slug'=>'approval',
            'order'=>3,
        ],[]);

\Admin::updateMenu([
            'parent_id'=>null,
            'title'=>'HRD',
            'controller'=>'#',
            'slug'=>'approval',
            'order'=>3,
        ],[]);

		\Admin::addMenu([
            'parent_id'=>'approval',
            'title'=>'Cuti',
            'controller'=>'Admin\Approval\CutiController',
            'slug'=>'approval-cuti',
            'order'=>1,
        ],['index','view']);

        \Admin::updateMenu([
            'parent_id'=>'approval',
            'title'=>'Approval Cuti',
            'controller'=>'Admin\Approval\CutiController',
            'slug'=>'approval-cuti',
            'order'=>1,
        ],['index','view']);

        \Admin::addMenu([
            'parent_id'=>'approval',
            'title'=>'Sakit,Izin dan Alpha',
            'controller'=>'Admin\Approval\SakitController',
            'slug'=>'approval-sakit-izin-alpha',
            'order'=>2,
        ],['index']);

        \Admin::updateMenu([
            'parent_id'=>'approval',
            'title'=>'Sakit,Izin dan Alpha',
            'controller'=>'Admin\Approval\SakitController',
            'slug'=>'approval-sakit-izin-alpha',
            'order'=>2,
        ],['index','delete','create']);

        \Admin::addMenu([
            'parent_id'=>'approval',
            'title'=>'Gaji,Bonus dan THR',
            'controller'=>'Admin\Approval\GajiController',
            'slug'=>'approval-gaji',
            'order'=>2,
        ],['index','update','delete','view','create']);

            \Admin::updateMenu([
                'parent_id'=>'approval',
                'title'=>'Gaji,Bonus dan THR',
                'controller'=>'Admin\Approval\GajiController',
                'slug'=>'approval-gaji',
                'order'=>2,
            ],['index','delete','view','create']);