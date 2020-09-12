<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function admin(){
        return $this->belongsTo('App\Employee','admin_id','id');
    }

    public function members(){
        return $this->hasMany('App\Task_member', 'task_id', 'id');
    }

    public function reply(){
        return $this->hasOne('App\Task_reply', 'task_id', 'id');
    }

    public function task_members(){
        return $this->hasMany('App\Employee_per_task', 'task_id', 'id');
    }

}
