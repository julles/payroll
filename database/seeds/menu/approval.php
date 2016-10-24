<?php
\Admin::addMenu([
            'parent_id'=>null,
            'title'=>'Approval',
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