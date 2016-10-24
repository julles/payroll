<?php

namespace App\Http\Controllers\Admin\Approval;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\EmployeeLeave;
use Table;
use Admin;

class CutiController extends AdminController
{
    public function __construct(EmployeeLeave $model)
    {
    	parent::__construct();

    	$this->model = $model;

    	$this->view = 'admin.approval.cuti.';
    }

    public function getData()
    {
        $fields = [
            'employee_leaves.id',
            'start_date',
            'end_date',
            'employee_leaves.status as status_cuti',
            'reason',
            'total_day',
            'master_employees.name',
            'master_employees.nip',
        ];

        $model = $this->model->select($fields)
        ->join('master_employees','master_employees.id','=','employee_leaves.employee_id');

        return Table::of($model)
        ->editColumn('status_cuti' ,function($model){
                if($model->status_cuti == 'pending')
                {
                    $val = "<label class = 'label pull-right bg-yellow'>Pending</label>";
                }elseif($model->status_cuti == 'approve'){
                    $val = "<label class = 'label pull-right bg-green'>Approve</label>";
                }elseif($model->status_cuti == 'reject'){
                    $val = "<label class = 'label pull-right bg-red'>Reject</label>";
                }
                return $val;
        })
        ->editColumn('name' ,function($model){
                return $model->nip.' - '.$model->name;
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

    public function getView($id)
    {
        $model = $this->model->findOrFail($id);
        
        return view($this->view.'view',compact('model'));
    }
}
