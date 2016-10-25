<?php

namespace App\Http\Controllers\Admin\Approval;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\AbsenNotPresent;
use Table;
use Admin;
use SqlRepo;

class SakitController extends AdminController
{
	public function __construct(AbsenNotPresent $model)
    {
    	parent::__construct();
    	$this->model = $model;
    	$this->view = 'admin.approval.sakit.';
    }

    public function setForm()
    {
        $forms = [
            'date' => [
                'type'=>'text',
                'label'=>'Tanggal',
                'properties'=>['class'=>'form-control','id'=>'datepicker','readonly'=>true,"onchange"=>"getPegawai()"],
            ],
            'employee_id' => [
                'type'=>'select',
                'label'=>'Pegawai',
                'properties'=>['class'=>'form-control select2','id'=>'employee_id'],
                'selects'=>[''=>'Pilih Pegawai'],
            ],
            'status' => [
                'type'=>'select',
                'properties'=>['class'=>'form-control'],
                'selects'=>[
                	'alpha'=>'Alpha',
                	'sakit'=>'Sakit',
                	'izin'=>'Izin',
                ],
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
            'absen_not_presents.id',
            'absen_not_presents.status as status',
            'name',
            'date',
            'reason',
        ];

        $model = $this->model->select($fields)
        	->join('master_employees','master_employees.id','=','absen_not_presents.employee_id');

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

    public function getPegawai()
    {
    	$date = request()->get('date');
    	$query = SqlRepo::comboEmployeeSakit($date);
    	
    	$result = "<option value = ''>Pilih Pegawai</option>";
    	foreach($query as $id => $nip_name)
    	{
    		$result.="<option value = '".$id."'>$nip_name</option>";
    	}

    	return response()->json([
    		'result'=>$result,
    	]);
    }

    public function getCreate()
    {
        return $this->form($this->model,$this->setForm());
    }

    public function postCreate(Request $request)
    {
    	$rules = [
    		'date'=>'required',
    		'employee_id'=>'required',

    	];

    	$this->validate($request,$rules);

    	return $this->insertOrUpdate($request->all(),$this->model);
    }

    public function getDelete($id)
    {
    	return $this->delete($this->model->findOrFail($id));
    }
}
