<?php

namespace App\Http\Controllers\Admin\Approval;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Pay;
use App\Models\MasterEmployee;
use App\Models\Absent;
use Table;
use Admin;
use SqlRepo;

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

    public function years()
    {
        $cek = Pay::select(\DB::raw("YEAR(`year`)"))->groupBy("YEAR(`year`)")->get()->toArray();
        if(!empty($cek))
        {
            $result = [];

            foreach($cek as $row)
            {
                $result[$row]=$row;
            }
        }else{
            $result = [date("Y") => date("Y")];
        }
        return $result;
    }

    
    public function getCreate()
    {
    	$model = $this->model;
        return view($this->view.'_form',[
    		'model'=>$model,
    	    'years'=>$this->years(),
        ]);
    }

    public function getGenerate()
    {
    	$year = request()->get('year');
    	$month = request()->get('month');

    	$model = MasterEmployee::all();

    	$str = "<tr>";

    	foreach($model as $row){
            $totalUangMakan = SqlRepo::totalUangMakan($row,$year,$month);
            $totalTransport = SqlRepo::totalTransport($row,$year,$month);
            $countLembur = SqlRepo::counLemburPerMonth($row,$year,$month);
            $countThr = SqlRepo::countThr($row,$year,$month);
            $totalPenghasilanSebelumPph = SqlRepo::totalPenghasilanSebelumPph($row,$year,$month);
            $countPph = SqlRepo::countPph($row,$totalPenghasilanSebelumPph);
            $total = $totalPenghasilanSebelumPph - $countPph + $countThr + 1;
            
    		$str .= "<td>".$row->nip.'-'.$row->name."</td>";
    		$str .= "<td>".Admin::formatMoney($row->basic_salary)."</td>";
            $str .= "<td>".Admin::formatMoney($totalUangMakan)."</td>";
            $str .= "<td>".Admin::formatMoney($totalTransport)."</td>";
    		$str .= "<td>".Admin::formatMoney($countLembur)."</td>";
    		$str .= "<td>".Admin::formatMoney($countThr)."</td>";
            $str .= "<td>".Admin::formatMoney($countPph)."</td>";
    		$str .= "<td>".Admin::formatMoney($total)."</td>";
    	}

    	$str .= "</tr>";

    	return response()->json([
    		'result'=>$str,
    	]);
    }

    

}
