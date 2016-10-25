<?php

namespace App\Http\Controllers\Admin\MasterData;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\MasterThr;
use Table;
use Admin;


class ThrController extends AdminController
{
    public function __construct(MasterThr $model)
    {
    	parent::__construct();
    	$this->model = $model;
    	$this->view = 'admin.master_data.thr.';
    }

    public function setForm()
    {
        $forms = [
            'date' => [
                'type'=>'text',
                'label'=>'Tanggal',
                'properties'=>['class'=>'form-control','id'=>'datepicker','readonly'=>true]
            ],
        ];

        return $forms;
    }

    public function getData()
    {
        $fields = [
            'id',
            'date',
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

    public function postCreate(Request $request)
    {
    	$rules = ['date'=>'required'];

    	$this->validate($request,$rules);

    	$date = explode("-",$request->date);
    	
    	$year = $date[0];
    	
    	$cek = $this->model->whereRaw("YEAR(date) =  $year")->count();

    	if($cek > 0)
    	{
    		return redirect()->back()->withInfo('Tahun '.$year.' sudah diinput sebelumnya');
    	}

    	return $this->insertOrUpdate($request->all(),$this->model);
    }	

    public function getUpdate($id)
    {
        return $this->form($this->model->findOrFail($id),$this->setForm());
    }

    public function postUpdate(Request $request,$id)
    {
    	$model = $this->model->findOrFail($id);

    	$rules = ['date'=>'required'];

    	$this->validate($request,$rules);

    	$date = explode("-",$request->date);
    	
    	$year = $date[0];
    	
    	$cek = $this->model->whereRaw("YEAR(date) =  $year")
    	->whereNotIn('id',[$model->id])
    	->count();

    	if($cek > 0)
    	{
    		return redirect()->back()->withInfo('Tahun '.$year.' sudah diinput sebelumnya');
    	}

    	return $this->insertOrUpdate($request->all(),$model);
    }

    public function getDelete($id)
    {
    	return $this->delete($this->model->findOrFail($id));
    }	
}
