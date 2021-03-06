<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterPosition;
use App\Models\Absent;

class MasterEmployee extends Model
{
    public $guarded = ['department_id'];
	
	public $dates = ['date_of_birth','join_date'];    

    public function position()
    {
    	return $this->belongsTo(MasterPosition::class,'position_id');
    }

    public function absents()
    {
    	return $this->hasMany(Absent::class,'employee_id');
    }

    public function getNipNameAttribute()
    {
        return $this->nip.' - '.$this->name;
    }
}
