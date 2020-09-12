<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dtr_request extends Model
{
    use SoftDeletes;
    protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function employee(){
        return $this->belongsTo('App\Employee','employee_id','id');
    }

    public function admin(){
        return $this->belongsTo('App\Employee','admin_id','id');
    }

    public function daterequests(){
        return $this->hasMany('App\Dtr_request_date', 'dtr_request_id', 'id');
    }
}
