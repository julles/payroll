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

	public function setForm()
    {
        $forms = [
            'department_id' => [
                'type'=>'select',
                'label'=>'Department',
                'properties'=>['class'=>'form-control','id'=>'department_id'],
                'selects'=> [''=>'Pilih Departemen']+SqlRepo::comboDepartments(),
            ],
            'position_id' => [
                'type'=>'select',
                'label'=>'Jabatan',
                'properties'=>['class'=>'form-control','id'=>'position_id'],
                'selects'=> [''=>'Pilih Jabatan'],
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
        ];

        return $forms;
    }

    public function getJabatan()
    {
    	$id = request()->get('id');

    	$model = SqlRepo::comboPositions($id);
    	return response()->json([
    		'result'=>$model,
    	]);
    }

    public function getData()
    {
        $fields = [
            'id',
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
}
