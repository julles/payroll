<?php

namespace App\Http\Controllers\Admin\Approval;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Pay;
use App\Models\PayDetail;
use App\Models\MasterEmployee;
use App\Models\Absent;
use Table;
use Admin;
use SqlRepo;
use Excel;

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
            'id','year','month',
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

    }

    
    public function getCreate()
    {
    	$model = $this->model;
        return view($this->view.'_form',[
    		'model'=>$model,
    	    'years'=>$this->years(),
        ]);
    }

    public function postCreate(Request $request)
    {
        $cek = Pay::where('year',$request->year)
            ->where('month',$request->month)
            ->first();

        if(!empty($cek))
        {
            return redirect()->back()
                ->withInfo('maaf data tersebut sudah ada');
        }

            $count = count($request->employee_id);

            if($count > 0)
            {
                   $pay = Pay::create([
                        'year'=>$request->year,
                        'month'=>$request->month,
                        'user_id'=>user()->id,
                    ]);

                    $datas = [];

                    for($a=0;$a<$count;$a++)
                    {
                        
                            $datas[] = [
                                'pay_id'=>$pay->id,
                                'employee_id'=>$request->employee_id[$a],
                                'gaji_pokok'=>$request->gaji_pokok[$a],
                                'total_uang_makan'=>$request->total_uang_makan[$a],
                                'total_transport'=>$request->total_transport[$a],
                                'total_lembur'=>$request->total_lembur[$a],
                                'thr'=>$request->thr[$a],
                                'pph21'=>$request->pph21[$a],
                                'total'=>$request->pph21[$a],
                            ];
                        
                    }

                    PayDetail::insert($datas);

                    return redirect(Admin::urlBackendAction('index'))
                        ->withSuccess('data telah disimpan');
            }else{
                    return redirect()
                        ->back()
                        ->withInfo('anda belum menggenarate apapun');
            }
    }

    public function getGenerate()
    {
    	$year = request()->get('year');
    	$month = request()->get('month');

    	$model = MasterEmployee::all();

    	$str = "";

    	foreach($model as $row){
            $totalUangMakan = SqlRepo::totalUangMakan($row,$year,$month);
            $totalTransport = SqlRepo::totalTransport($row,$year,$month);
            $countLembur = SqlRepo::counLemburPerMonth($row,$year,$month);
            $countThr = SqlRepo::countThr($row,$year,$month);
            $totalPenghasilanSebelumPph = SqlRepo::totalPenghasilanSebelumPph($row,$year,$month);
            $countPph = SqlRepo::countPph($row,$totalPenghasilanSebelumPph);
            $total = $totalPenghasilanSebelumPph - $countPph + $countThr + 1;
            $str .= "<tr>";
    		$str .= "<td><input type = 'hidden' name = 'employee_id[]' value = '$row->id'/>".$row->nip.'-'.$row->name."</td>";
    		$str .= "<td><input type = 'hidden' name = 'gaji_pokok[]' value = '$row->basic_salary' />".Admin::formatMoney($row->basic_salary)."</td>";
            $str .= "<td><input type = 'hidden' name = 'total_uang_makan[]' value = '$row->totalUangMakan' />".Admin::formatMoney($totalUangMakan)."</td>";
            $str .= "<td><input type = 'hidden' name = 'total_transport[]' value = '$totalTransport'/>".Admin::formatMoney($totalTransport)."</td>";
    		$str .= "<td><input type = 'hidden' name = 'total_lembur[]' value = '$countLembur' />".Admin::formatMoney($countLembur)."</td>";
    		$str .= "<td><input type = 'hidden' name = 'thr[]' value = '$countThr' />".Admin::formatMoney($countThr)."</td>";
            $str .= "<td><input type = 'hidden' name = 'pph21[]' value = '$countPph'/>".Admin::formatMoney($countPph)."</td>";
    		$str .= "<td><input type = 'hidden' name = 'total[]' value ='$total' />".Admin::formatMoney($total)."</td>";
    	   $str .= "</tr>";
            
        }

    	
    	return response()->json([
    		'result'=>$str,
    	]);
    }

    public function getView($id)
    {
        $model = $this->model->findOrFail($id);

        return view($this->view.'view',compact('model'));
    }

    public function getExcel($id)
    {
        Excel::create('excel', function($excel) use($id){
            $excel->sheet('New sheet', function($sheet) use($id) {
                $model = $this->model->findOrFail($id);
                $sheet->loadView($this->view.'excel',['model'=>$model]);

            });

        })->download('xls');
    }

    public function getDelete($id)
    {
        return $this->delete($this->model->findOrFail($id));
    }       

}   
