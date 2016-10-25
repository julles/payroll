<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterEmployee;

class AbsenNotPresent extends Model
{
    protected $guarded = [];

    //protected $dates = ['date'];

    public function employee()
    {
    	return $this->belongsTo(MasterEmployee::class,'employee_id');
    }
}
