<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterPosition;

class MasterEmployee extends Model
{
    public $guarded = ['department_id'];
	
	public $dates = ['date_of_birth','join_date'];    

    public function position()
    {
    	return $this->belongsTo(MasterPosition::class,'position_id');
    }
}
