<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task_member extends Model
{
    use SoftDeletes;
    protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function task(){
        return $this->belongsTo('App\Task','task_id','id');
    }

    public function group(){
        return $this->belongsTo('App\Employee_group','group_id','id');
    }

    public function employee(){
        return $this->belongsTo('App\Employee','employee_id','id');
    }
}
