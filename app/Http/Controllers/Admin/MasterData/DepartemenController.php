<?php

namespace App\Http\Controllers\Admin\MasterData;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\MasterDepartment;
use Table;
use Admin;

class DepartemenController extends AdminController
{
    public function __construct(MasterDepartment $model)
    {
    	parent::__construct();
    	$this->model = $model;
    	$this->view = 'admin.master_data.departemen.';
    }

    public function setForm()
    {
        $forms = [
            'department' => [
                'type'=>'text',
                'label'=>'Departemen',
                'properties'=>['class'=>'form-control']
            ],
        ];

        return $forms;
    }

    public function getData()
    {
        $fields = [
            'id',
            'department',
        ];

        $model = $this->model->select($fields);

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

    public function postCreate(Requests\Admin\MasterData\Departemen $request)
    {
    	return $this->insertOrUpdate($request->all(),$this->model);
    }	

    public function getUpdate($id)
    {
        return $this->form($this->model->findOrFail($id),$this->setForm());
    }

    public function postUpdate(Requests\Admin\MasterData\Departemen $request,$id)
    {
    	return $this->insertOrUpdate($request->all(),$this->model->findOrFail($id));
    }

    public function getDelete($id)
    {
    	return $this->delete($this->model->findOrFail($id));
    }	
}
