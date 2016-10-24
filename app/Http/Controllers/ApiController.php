<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\FingerStatus;

class ApiController extends Controller
{
    public function getIndex()
    {
    }

    public function getStatus()
    {
        $model = FingerStatus::findOrFail(1);

        echo $model->status.'-'.$model->employee_id;
    }

    public function getUpdate($employee_id,$status)
    {
        $model = FingerStatus::findOrFail(1);

        $model->update([
            'employee_id'=>$employee_id,
            'status'=>$status,
        ]);
    }

}
