<?php namespace Admin\Helper;

use App\Models\MasterDepartment;
use App\Models\MasterEmployee;
use App\Models\EmployeeLeave;
use App\Models\Absent;
use App\Models\MasterPosition;
use App\User;
use App\Models\MasterCalendar;
use App\Models\MasterThr;
use Carbon\Carbon;

class SqlRepo
{
	public function comboDepartments()
	{
		$model = MasterDepartment::lists('department','id')
			->toArray();

		return $model;
	}

	public function comboPositions($department_id = "")
	{
		$model = new MasterPosition;

		if(!empty($department_id))
		{
			$model = $model->whereDepartmentId($department_id);
		}

		$model = $model->lists('position','id')
			->toArray();

		return $model;
	}

	public function comboUserFiltered($id = "")
	{
		$model = new User;

		$notIn = MasterEmployee::select('user_id')
		->get();

		if(!empty($id))
		{
			$notIn = $notIn->where('user_id','!=',$id);

		}

		$notIn = array_flatten($notIn->toArray());
		$model = $model->whereNotIn('id',$notIn)
		->get()
		->lists('name_email','id')
		->toArray();

		return $model;

	}


	public function countCalendar($start_date,$end_date)
    {
    	$model = MasterCalendar::where('date' , '>=',$start_date)
    		->where('date','<=',$end_date)
    		->count();

    	return $model;
    }

    public function countSaturydaySunday($start_date,$end_date)
    {
        $interval = \DateInterval::createFromDateString('1 day');

        $begin = new \DateTime($start_date);
        $end = new \DateTime($end_date);

        $period = new \DatePeriod($begin, $interval, $end->modify("+ 1 day"));

        $count = 0;
        foreach ( $period as $dt )
        {
          $day =  strtolower($dt->format("D"));
          if($day == 'sat' || $day == 'sun')
          {
            $count = $count + 1;
          }
        }

        return $count;

    }

    public function totalDay($start_date,$end_date)
    {
    	$countCalendar = $this->countCalendar($start_date,$end_date);
        $countSaturydaySunday = $this->countSaturydaySunday($start_date,$end_date);
    	$end_date = Carbon::parse($end_date);
    	$start_date = Carbon::parse($start_date);
        $totalCarbon = $end_date->diffInDays($start_date) + 1 - $countCalendar - $countSaturydaySunday;
    	
        return $totalCarbon;
    }

    public function comboEmployeeSakit($date)
    {
    	$tanggal = explode("-",$date);

    	$model = new MasterEmployee;

    	$cekAbsent = Absent::select('employee_id')
    	->whereRaw("YEAR(`enter`) = $tanggal[0] AND MONTH(`enter`)=$tanggal[1] AND DAY(`enter`)=$tanggal[2]")
    	->get()
    	->toArray();

    	$cekAbsent = array_flatten($cekAbsent);

    	$cekCuti = EmployeeLeave::select('employee_id')
    	->where('start_date','<=',$date)
    	->where('end_date','>=',$date)
    	->where('status','=','approve')
    	->get()
    	->toArray();

    	$cekCuti = array_flatten($cekCuti);

    	$ids = $cekAbsent + $cekCuti;

    	$query = $model->whereNotIn('id' , $ids)
    		->get()
    		->lists('nip_name','id')
    		->toArray();

    	return $query;
    }


    public function counLemburPerMonth($employee,$year,$month)
    {
        $jamKerja = 540; //minutes

        $models = $employee->absents()
        ->whereRaw("YEAR(`enter`)=$year AND MONTH(`enter`) = $month")
        ->get();

        $hour = 0;

        foreach($models as $model)
        {
            $jamPulang = $model->enter->AddMinutes($jamKerja);

            $lembur = $model->exit->diffInMinutes($jamPulang);

            if($lembur >= 60)
            {
                $converMenitKeJam = round($lembur / 60);
            
                $hour=$hour + $converMenitKeJam;
            }

        }

        return $hour * $employee->overtime;
    }

    public function countThr($employee,$year,$month)
    {
        $model = MasterThr::whereRaw("YEAR(`date`) = $year AND MONTH(`date`)=$month")
            ->first();

        if(!empty($model->id))
        {
            $tanggalThr = new Carbon($model->date);
            $totalBulanKerja = $tanggalThr->diffInMonths($employee->join_date);
            if($totalBulanKerja < 12)
            {
                $gajiPokokPerBulan = $employee->basic_salary / 12;
                $thr = $gajiPokokPerBulan * $totalBulanKerja;
            }else{
                $thr = $employee->basic_salary;
            }
        }else{
            $thr = 0;
        }

        return $thr;
    }

    public function totalUangMakan($employee,$year,$month)
    {
        $countAbsent = $employee->absents()->whereRaw("YEAR(`enter`)=$year AND MONTH(`enter`)=$month")->count();

        $result = $countAbsent * $employee->meal_allowance;

        return $result;
    }

    public function totalTransport($employee,$year,$month)
    {
        $countAbsent = $employee->absents()->whereRaw("YEAR(`enter`)=$year AND MONTH(`enter`)=$month")->count();

        $result = $countAbsent * $employee->transport;

        return $result;
    }

    public function totalPenghasilanSebelumPph($employee,$year,$month)
    {
        $lembur = $this->counLemburPerMonth($employee,$year,$month);
        //$thr = $this->countThr($employee,$year,$month);
        //$lembur = 0;
        $thr = 0;
        $totalUangMakan = $this->totalUangMakan($employee,$year,$month);
        $totalTransport = $this->totalTransport($employee,$year,$month);
        $result = $lembur + $thr + $totalUangMakan + $totalTransport + $employee->basic_salary;
        //dd("$lembur + $thr + $totalUangMakan + $totalTransport + $employee->basic_salary");
        return $result;
    }

    public function countPph($employee,$totalPenghasilanSebelumPph)
    {
        $totalGajiSetahun = $totalPenghasilanSebelumPph * 12;

        $persen = function() use($totalGajiSetahun){
            if($totalGajiSetahun <= 50000000)
            {
                $result = 5;
            }elseif($totalGajiSetahun > 50000000 && $totalGajiSetahun <= 250000000){
                $result = 15;
            }elseif($totalGajiSetahun > 250000000 && $totalGajiSetahun <= 500000000){
                $result = 25;
            }else{
                $result = 30;
            }

            return $result / 100;
        };

        $biaya_jabatan = $totalPenghasilanSebelumPph * $persen();
        $jaminan_tua = $employee->basic_salary * 2 /100;
        $iuranPensiun = 30000;

        $pph = $biaya_jabatan + $jaminan_tua + $iuranPensiun;

        return $pph;
    }
}