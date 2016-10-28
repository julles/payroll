<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function getIndex()
    {
    	$date = date("Y-m-d");
    	$resultDate = [];
    	
    	for($a=5;$a>=0;$a--)
    	{
    		$convert = strtotime("$date -$a day");
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
		            'data' => [1,2,3,4,5]
		        ],
		    ]
		];
		return view('admin.dashboard.index',[
    		'charts'=>$charts,
    	]);
    }
}
