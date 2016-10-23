<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\MasterEmployee;

class ApiController extends Controller
{
    public function getIndex()
    {
    	$model = MasterEmployee::find(1);
    	$finger_id = request()->get('finger_id');
    	echo $finger_id;
    	//return $finger_id;
    	// $model->update([
    	// 	'finger_id'=>$finger_id,
    	// ]);
    }
}
