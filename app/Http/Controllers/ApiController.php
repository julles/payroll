<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\FingerStatus;
use App\Models\MasterEmployee;
use App\Models\Absent;
use DB;
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

    public function getAbsen($param,$id)
    {
        $model = MasterEmployee::whereNip($id)->first();

        $y = date("Y");
        $m = date("m");
        $d = date("d");
        $sql = DB::raw("YEAR(enter) = '$y' AND MONTH(enter)='$m' AND DAY(enter)='$d'");
        $date = date("Y-m-d H:i:s");

        if($param == 'i')
        {
            if($model->absents()->whereRaw($sql)->count() == 0)
            {
                Absent::create([
                    'employee_id'=>$model->id,
                    'enter'=>$date,
                ]);

                echo "absen masuk berhasil";
            }
        }elseif($param == 'o'){
            if($model->absents()->whereRaw($sql)->count() > 0)
            {
                $model->absents()->whereRaw($sql)
                    ->first()
                    ->update([
                        'employee_id'=>$model->id,
                        'exit'=>$date,
                    ]);

                echo "absen keluar berhasil";
            }
        }

    }

}
