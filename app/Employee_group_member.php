<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Employee_group_member extends Model
{
    use SoftDeletes;
    protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function group(){
        return $this->belongsTo('App\Employee_group','employee_group_id','id');
    }

    public function employee(){
        return $this->belongsTo('App\Employee','employee_id','id');
    }
}
