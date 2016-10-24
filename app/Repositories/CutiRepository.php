<?php namespace App\Repositories;

use App\Models\MasterCalendar;
use Carbon\Carbon;

class CutiRepository
{
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
}