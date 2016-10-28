<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Models\PayDetail;

class Pay extends Model
{
    protected $guarded = [];

    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }

    public function details()
    {
    	return $this->hasMany(PayDetail::class,'pay_id');
    }
}
