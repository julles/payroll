<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\MasterEmployee;

class FingerStatus extends Model
{
	public $guarded = [];

    protected $table = 'finger_status';

    public function employee()
    {
    	return $this->belongsTo(MasterEmployee::class,'employee_id');
    }
}
