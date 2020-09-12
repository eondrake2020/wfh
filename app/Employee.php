<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function getFullNameAttribute()
    {
        return $this->lastname.', '.$this->firstname.' '.$this->middlename.' '.$this->extname;
    }

    public function campus(){
        return $this->belongsTo('App\Campus','campus_id','id');
    }

    public function user(){
        return $this->hasOne('App\User','employee_id','id');
    }

    public function tasks(){
        return $this->hasMany('App\Employee_per_task', 'employee_id', 'id');
    }

    public function schedule(){
        return $this->hasMany('App\Employee_schedule', 'employee_id', 'id');
    }

    public function correctives(){
        return $this->hasMany('App\Employee_corrective', 'employee_id', 'id');
    }
}
