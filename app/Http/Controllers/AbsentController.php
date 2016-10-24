<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\MasterEmployee;
use DB;
class AbsentController extends Controller
{
    public function getIndex()
    {
    	return view('absent.index');
    }

    public function getCek()
    {
    	$nip = request()->get('nip');
    	
    	$model = MasterEmployee::whereNip($nip)->first();
    	if(!empty($model->id))
    	{
    				$y = date("Y");
			        $m = date("m");
			        $d = date("d");
			    	$sql = DB::raw("YEAR(enter) = '$y' AND MONTH(enter)='$m' AND DAY(enter)='$d'");

			    	$cek = $model->absents()->whereRaw($sql);

			    	if(empty($cek->first()->id))
			    	{
			    		$result = 'absen_masuk';
			    	}else{
			    		$cek = $cek->whereRaw("YEAR(`exit`) = 0000")->first();
			    		
			    		if(empty($cek->id))
			    		{
			    			$result = 'false';
			    		}else{
			    			$result = 'absen_keluar';
			    		}
			    	}
		}else{
			$result = 'false';

    	}
			    	
    	return response()->json([
    		'result'=>$result,
    	]);
    }
}
