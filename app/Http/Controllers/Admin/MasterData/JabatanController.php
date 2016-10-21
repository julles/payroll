<?php

namespace App\Http\Controllers\Admin\MasterData;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\MasterPosition;
use Table;
use Admin;

class JabatanController extends AdminController
{
    public function __construct(MasterPosition $model)
    {
    	parent::__construct();
    	$this->model = $model;
    	$this->view = 'admin.master_data.jabatan.';
    }

    public function setForm()
    {
        $forms = [
        	'department_id' => [
                'type'=>'select',
                'label'=>'Departmen',
                'properties'=>['class'=>'form-control'],
            	'selects'=>\SqlRepo::comboDepartments(),
            ],
            'position' => [
                'type'=>'text',
                'label'=>'Jabatan',
                'properties'=>['class'=>'form-control']
            ],
        ];

        return $forms;
    }

    public function getData()
    {
        $fields = [
            'master_positions.id',
            'department',
            'position',
        ];

        $model = $this->model->select($fields)
        	->join('master_departments','master_departments.id','=','master_positions.department_id');

        return Table::of($model)
        ->addColumn('action' ,function($model){
                return Admin::linkActions($model->id);
        })
        ->make(true);
    }

    public function getIndex()
    {
        return view($this->view.'index');
    }

    public function getCreate()
    {
        return $this->form($this->model,$this->setForm());
    }

    public function postCreate(Requests\Admin\MasterData\Jabatan $request)
    {
    	return $this->insertOrUpdate($request->all(),$this->model);
    }	

    public function getUpdate($id)
    {
        return $this->form($this->model->findOrFail($id),$this->setForm());
    }

    public function postUpdate(Requests\Admin\MasterData\Jabatan $request,$id)
    {
    	return $this->insertOrUpdate($request->all(),$this->model->findOrFail($id));
    }

    public function getDelete($id)
    {
    	return $this->delete($this->model->findOrFail($id));
    }	
}
