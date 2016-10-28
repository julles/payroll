<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AbsenNotPresent;
use App\Models\EmployeeLeave;

class DashboardController extends Controller
{
    public function getIndex()
    {
    	$date = date("Y-m-d");
    	
    	$resultDate = [];
    	
    	$data = [];

    	for($a=5;$a>=0;$a--)
    	{
    		$convert = strtotime("$date -$a day");
    		
    		$ymd =date("Y-m-d",$convert);

    		$hitAlpha = AbsenNotPresent::where('date',$ymd)->count();

    		$hitCuti = EmployeeLeave::where('start_date','<=',$ymd)
    			->where('end_date','>=',$ymd)
    			->count();

    		$data[] = $hitAlpha + $hitCuti;

    		$resultDate[] =date("d, F Y",$convert);
    	}

    	$charts = [

		    'chart' => ['type' => 'column'],
		    'title' => ['text' => 'Jumlah Pegawai tidak masuk hari terakhir'],
		    'xAxis' => [
		        'categories' => $resultDate,
		    ],
		    'yAxis' => [
		        'title' => [
		            'text' => 'Jumlah Pegawai tidak masuk hari terakhir'
		        ]
		    ],
		    'series' => [
		        [
		            'name' => 'Reza',
		            'data' => $data,
		        ],
		    ]
		];

		return view('admin.dashboard.index',[
    		'charts'=>$charts,
    	]);
    }
}
