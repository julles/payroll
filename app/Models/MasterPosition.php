<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterDepartment;

class MasterPosition extends Model
{
    protected $fillable = ['department_id','position'];

    public function department()
    {
    	return $this->belongsTo(MasterDepartment::class,'department_id');
    }
}
