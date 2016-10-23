<?php

namespace App\Http\Controllers\Admin\Pegawai;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\EmployeeLeave;
use App\Models\MasterCalendar;
use Table;
use Admin;
use Carbon\Carbon;

class CutiController extends AdminController
{
 	public function __construct(EmployeeLeave $model)
 	{
 		parent::__construct();
 		$this->model = $model;
 		$this->view = 'admin.pegawai.cuti.';
 	}

 	public function setForm()
    {
        $forms = [
            'start_date' => [
                'type'=>'text',
                'label'=>'Tanggal Mulai',
                'properties'=>['class'=>'form-control','id'=>'from','readonly'=>true]
            ],
            'end_date' => [
                'type'=>'text',
                'label'=>'Sampai Tanggal',
                'properties'=>['class'=>'form-control','id'=>'to','readonly'=>true]
            ],
            'reason' => [
                'type'=>'textarea',
                'label'=>'Alasan',
                'properties'=>['class'=>'form-control'],
            ],
        ];

        return $forms;
    }

    public function getData()
    {
        $fields = [
            'id',
            'start_date',
            'end_date',
            'status',
            'reason',
        ];

        $model = $this->model->select($fields);

        return Table::of($model)
        ->editColumn('status' ,function($model){
                if($model->status == 'pending')
                {
                    $val = "<label class = 'label pull-right bg-yellow'>Pending</label>";
                }elseif($model->status == 'approve'){
                    $val = "<label class = 'label pull-right bg-green'>Approve</label>";
                }elseif($model->status == 'reject'){
                    $val = "<label class = 'label pull-right bg-red'>Reject</label>";
                }
                return $val;
        })
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

    public function postCreate(Requests\Admin\Pegawai\Cuti $request)
    {
    	$inputs = $request->all();
    	$inputs['total_day']=$this->total($request->start_date,$request->end_date);
    	$inputs['employee_id']=user()->id;
    	
    	if($inputs['total_day'] <= 0)
    	{
    		return redirect()->back()
    			->with('info','Maaf anda tidak bisa cuti di tanggal tersebut');
    	}		
    	return $this->insertOrUpdate($inputs,$this->model);
    }

    public function getUpdate($id)
    {
        $model = $this->model->findOrFail($id);

        if($model->status != 'pending')
        {
            return redirect()->back()->with('info','You cannot update this data');
        }

        return $this->form($model,$this->setForm());
    }

    public function postUpdate(Requests\Admin\Pegawai\Cuti $request,$id)
    {
        $model = $this->model->findOrFail($id);
        if($model->status != 'pending')
        {
            return redirect()->back()->with('info','You cannot update this data');
        }
        $inputs = $request->all();

        $inputs['total_day']=$this->total($request->start_date,$request->end_date);
        $inputs['employee_id']=user()->id;
        
        if($inputs['total_day'] <= 0)
        {
            return redirect()->back()
                ->with('info','Maaf anda tidak bisa cuti di tanggal tersebut');
        }       
        return $this->insertOrUpdate($inputs,$model);
    }

    public function getDelete($id)
    {
        $model = $this->model->findOrFail($id);
        if($model->status != 'pending')
        {
            return redirect()->back()->with('info','You cannot delete this data');
        }
        return $this->delete($model);
    }

    public function countCalendar($start_date,$end_date)
    {
    	$model = MasterCalendar::where('date' , '>=',$start_date)
    		->where('date','<=',$end_date)
    		->count();

    	return $model;
    }

    public function total($start_date,$end_date)
    {
    	$countCalendar = $this->countCalendar($start_date,$end_date);
    	$end_date = Carbon::parse($end_date);
    	$start_date = Carbon::parse($start_date);
        $totalCarbon = $end_date->diffInDays($start_date) + 1 - $countCalendar;
    	return $totalCarbon;
    }   
}
