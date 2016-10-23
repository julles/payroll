<?php

namespace App\Http\Controllers\Admin\MasterData;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\MasterEmployee;
use Table;
use Admin;
use SqlRepo;

class PegawaiController extends AdminController
{
	public function __construct(MasterEmployee $model)
	{
		parent::__construct();
		$this->model = $model;
    	$this->view = 'admin.master_data.pegawai.';
	}

	public function position($position_id)
	{
		return [''=>'Pilih Jabatan'] + SqlRepo::comboPositions($position_id);
	}

	public function setForm($department="")
    {
        $forms = [
            'user_id' => [
                'type'=>'select',
                'label'=>'User',
                'properties'=>['class'=>'form-control'],
                'selects'=> [''=>'Pilih User'] + SqlRepo::comboUserFiltered(request()->segment(4)),
            ],
            'department_id' => [
                'type'=>'select',
                'label'=>'Department',
                'properties'=>['class'=>'form-control','id'=>'department_id'],
                'selects'=> [''=>'Pilih Departemen']+SqlRepo::comboDepartments(),
                'value'=>$department,
            ],
            'position_id' => [
                'type'=>'select',
                'label'=>'Jabatan',
                'properties'=>['class'=>'form-control','id'=>'position_id'],
                'selects'=> $this->position(request()->department_id),
            ],
            'nip' => [
                'type'=>'text',
                'label'=>'Nip',
                'properties'=>['class'=>'form-control','maxlength'=>'10'],
            ],
            'name' => [
                'type'=>'text',
                'label'=>'Nama',
                'properties'=>['class'=>'form-control','maxlength'=>'30'],
            ],
            'gender' => [
                'type'=>'select',
                'label'=>'Jenis Kelamin',
                'properties'=>['class'=>'form-control'],
                'selects'=> ['m'=>'Laki Laki','w'=>'Perempuan'],
            ],
            'place_of_birth' => [
                'type'=>'text',
                'label'=>'Tempat Lahir',
                'properties'=>['class'=>'form-control','maxlength'=>'30'],
            ],
            'date_of_birth' => [
                'type'=>'text',
                'label'=>'Tanggal Lahir',
                'properties'=>['class'=>'form-control','readonly'=>true,'id'=>'datepicker'],
            ],
            'address' => [
                'type'=>'textarea',
                'label'=>'Alamat',
                'properties'=>['class'=>'form-control'],
            ],
            'postal_code' => [
                'type'=>'text',
                'label'=>'Kode Pos',
                'properties'=>['class'=>'form-control','maxlength'=>'10'],
            ],
            'phone' => [
                'type'=>'text',
                'label'=>'No Telepon',
                'properties'=>['class'=>'form-control','maxlength'=>'15'],
            ],
            'religion' => [
                'type'=>'select',
                'label'=>'Agama',
                'properties'=>['class'=>'form-control'],
                'selects'=> [
                		'islam'=>'Islam',
                		'kristen'=>'Kristen',
                		'katolik'=>'Katolik',
                		'budha'=>'Budha',
                		'konghucu'=>'Konghucu',
               	],
            ],
            'number_id' => [
                'type'=>'text',
                'label'=>'No Identitas',
                'properties'=>['class'=>'form-control','maxlength'=>'20'],
            ],
            'foto'	=> [
    			'type'=>'file',
    			'properties'=>[
    				'class'=>null,
    			],
    		],
    		'join_date' => [
                'type'=>'text',
                'label'=>'Tanggal Masuk',
                'properties'=>['class'=>'form-control','readonly'=>true,'id'=>'datepicker2'],
            ],
            'basic_salary' => [
                'type'=>'text',
                'label'=>'Gaji Pokok',
                'properties'=>['class'=>'form-control','maxlength'=>'15'],
            ],
            'meal_allowance' => [
                'type'=>'text',
                'label'=>'Uang Makan',
                'properties'=>['class'=>'form-control','maxlength'=>'15'],
            ],
            'transport' => [
                'type'=>'text',
                'properties'=>['class'=>'form-control','maxlength'=>'15'],
            ],
        ];

        return $forms;
    }

    public function getJabatan()
    {
    	if(request()->ajax())
    	{
    		$id = request()->get('id');

	    	$model = SqlRepo::comboPositions($id);
	    	return response()->json([
	    		'result'=>$model,
	    	]);
    	}
	}

    public function getData()
    {
        $fields = [
            'id',
            'nip',
            'name',
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

    public function postCreate(Requests\Admin\MasterData\Pegawai $request)
    {
   		$inputs = $request->all();
   		$inputs['foto']=$this->handleUpload($request,$this->model,'foto',[100,100]);
		$inputs['overtime']=$this->overtime($request->basic_salary);
		return $this->insertOrUpdate($inputs,$this->model);
    }

    public function getUpdate($id)
    {
    	$model = $this->model->findOrFail($id);

    	$department = $model->position->department_id;

        return $this->form($model,$this->setForm($department));
    }

    public function postUpdate(Requests\Admin\MasterData\Pegawai $request,$id)
    {
    	$model = $this->model->findOrFail($id);
   		$inputs = $request->all();
   		$inputs['foto']=$this->handleUpload($request,$model,'foto',[100,100]);
		$inputs['overtime']=$this->overtime($request->basic_salary);
		return $this->insertOrUpdate($inputs,$model);
    }

    public function getView($id)
    {
    	$model = $this->model->findOrFail($id);
    	return view($this->view.'view',compact('model'));
    }

    public function overtime($basic_salary)
    {
    	$day = $basic_salary / 20;

    	$hour = $day / 9;

    	return ceil($hour);
    }

    public function getDelete($id)
    {
        $model = $this->model->findOrFail($id);
        return $this->delete($model,[$model->foto]);
    }
}
