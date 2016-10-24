<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\MasterEmployee;

class Absent extends Model
{
	public $guarded = [];

    public function employee()
    {
    	return $this->belongsTo(MasterEmployee::class,'employee_id');
    }
}
