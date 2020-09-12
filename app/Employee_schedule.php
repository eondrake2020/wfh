<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee_schedule extends Model
{
    use SoftDeletes;
    protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function employee(){
        return $this->belongsTo('App\Employee','employee_id','id');
    }

    public function weekday(){
        return $this->belongsTo('App\Weekday','weekday_id','id');
    }
}
