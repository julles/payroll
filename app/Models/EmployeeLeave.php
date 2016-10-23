<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class EmployeeLeave extends Model
{
    public $guarded = [];

    //public $dates = ['start_date','end_date'];

    public function employee()
    {
    	return $this->belongsTo(User::class,'employee_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class,'approve_id');
    }
}
