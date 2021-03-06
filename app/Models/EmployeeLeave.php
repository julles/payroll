<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterEmployee;

class EmployeeLeave extends Model
{
    public $guarded = [];

    public $dates = ['start_date','end_date'];

    public function employee()
    {
    	return $this->belongsTo(MasterEmployee::class,'employee_id');
    }

    public function user()
    {
    	return $this->belongsTo(MasterEmployee::class,'approve_id');
    }
}
