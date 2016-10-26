<?php

namespace App\Http\Controllers\Admin\Approval;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Pay;
use App\Models\MasterEmployee;
use Table;
use Admin;

class GajiController extends AdminController
{
    public function __construct(Pay $model)
    {
    	parent::__construct();
    	$this->model = $model;
    	$this->view = 'admin.approval.gaji.';
    }

    public function getData()
    {
        $fields = [
            'id',
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
    	$model = $this->model;

    	return view($this->view.'_form',[
    		'model'=>$model,
    	]);
    }

    public function getGenerate()
    {
    	$year = request()->get('year');
    	$month = request()->get('month');

    	$model = MasterEmployee::all();

    	$str = "<tr>";

    	foreach($model as $row){
    		$str .= "<td>".$row->nip.'-'.$row->name."</td>";
    		$str .= "<td>".Admin::formatMoney($row->basic_salary)."</td>";
    		$str .= "<td></td>";
    		$str .= "<td></td>";
    		$str .= "<td></td>";
    	}

    	$str .= "</tr>";

    	return response()->json([
    		'result'=>$str,
    	]);
    }

}
