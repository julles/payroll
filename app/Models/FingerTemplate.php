<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\MasterEmployee;


class FingerTemplate extends Model
{

	public $guarded = [];

    protected $table = 'finger_template';

    public function employee()
    {
    	return $this->belongsTo(MasterEmployee::class,'employee_id');
    }
}
