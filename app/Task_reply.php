<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task_reply extends Model
{
    use SoftDeletes;
    protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function employee(){
        return $this->belongsTo('App\Employee','employee_id','id');
    }

    public function task(){
        return $this->belongsTo('App\Task','task_id','id');
    }
}
