<?php

namespace App\Http\Controllers\Admin\Pegawai;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\EmployeeLeave;
use Table;
use Admin;
use SqlRepo;

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
            'total_day'
        ];

        $model = $this->model->select($fields)
            ->where('employee_id',user()->id);

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
        $model = user()->employee()->count();
        if($model > 0)
        {
            return view($this->view.'index');
        }else{
            echo "<h2>ANDA Belum terdaftar sebagai pegawai</h2>";
        }
    }

    public function getCreate()
    {
        return $this->form($this->model,$this->setForm());
    }

    public function postCreate(Requests\Admin\Pegawai\Cuti $request)
    {
    	$inputs = $request->all();
    	$inputs['total_day']=SqlRepo::totalDay($request->start_date,$request->end_date);
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

        $inputs['total_day']=SqlRepo::totalDay($request->start_date,$request->end_date);
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
}
