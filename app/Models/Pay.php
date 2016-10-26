<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Pay extends Model
{
    protected $guarded = [];

    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }

}
