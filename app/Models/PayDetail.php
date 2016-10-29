<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterEmployee;
use App\Models\Pay;

class PayDetail extends Model
{
    public $guarded = [];

    public function employee()
    {
    	return $this->belongsTo(MasterEmployee::class,'employee_id');
    }

    public function pay()
    {
    	return $this->belongsTo(Pay::class,'pay_id');
    }
}
