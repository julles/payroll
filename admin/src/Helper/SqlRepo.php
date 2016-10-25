<?php namespace Admin\Helper;

use App\Models\MasterDepartment;
use App\Models\MasterEmployee;
use App\Models\EmployeeLeave;
use App\Models\Absent;
use App\Models\MasterPosition;
use App\User;
use App\Models\MasterCalendar;
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

}