<?php

namespace App\Http\Controllers\Admin\MasterData;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use Table;
use App\Models\MasterCalendar;
use DB;
use Admin;

class KalenderController extends AdminController
{
    public function __construct(MasterCalendar $model)
	{
        parent::__construct();
		$this->model = $model;
        $this->view = 'admin.master_data.kalender.';
    }

    public function types()
    {
    	$arrays = ['libur_nasional','cuti_bersama','even_non_libur'];

    	$result = [];

    	foreach($arrays as $row)
    	{
    		$result[$row]=Admin::toString($row);
    	}

    	return $result;
    }

    public function setForm()
    {
        $forms = [
            'date' => [
                'type'=>'text',
                'label'=>'Tanggal',
                'properties'=>['class'=>'form-control','readonly'=>true,'id'=>'datepicker']
            ],
            'event_name' => [
                'type'=>'text',
                'label'=>'Nama Event',
                'properties'=>['class'=>'form-control','maxlength'=>100,]
            ],
            'type' => [
                'type'=>'select',
                'label'=>'Select',
                'properties'=>['class'=>'form-control'],
                'selects'=>$this->types(),
            ],
        ];

        return $forms;
    }

    public function getData()
    {
        $fields = [
            'id',
            'date',
            'event_name',
            'type',
        ];

        $model = $this->model->select($fields);

        return Table::of($model)
         ->addColumn('type' ,function($model){
                return Admin::toString($model->type);
        })
         ->editColumn('date' ,function($model){
                return $model->date->format("d-m-Y");
        })
        ->addColumn('action' ,function($model){
                return Admin::linkActions($model->id);
        })
         ->filterColumn('type', function($query, $keyword) {
                $keyword = Admin::toUnderscore($keyword);
                $query->whereRaw("type like ?", ["%{$keyword}%"]);
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

    public function postCreate(Requests\Admin\MasterData\Kalender $request)
    {
    	return $this->insertOrUpdate($request->all(),$this->model);
    }

    public function getUpdate($id)
    {
    	$model = $this->model->findOrFail($id);
    	$model->date = $model->date->format("Y-m-d");
        return $this->form($model,$this->setForm());
    }

    public function postUpdate(Requests\Admin\MasterData\Kalender $request,$id)
    {
    	return $this->insertOrUpdate($request->all(),$this->model->findOrFail($id));
    }

    public function getDelete($id)
    {
    	return $this->delete($this->model->findOrFail($id));
    }
}
