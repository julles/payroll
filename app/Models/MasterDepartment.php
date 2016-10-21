<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterPosition;

class MasterDepartment extends Model
{
    protected $fillable = ['department'];

    public function position()
    {
    	return $this->hasMany(MasterPosition,'position_id');
    }
}
