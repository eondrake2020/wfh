<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Employee_group extends Model
{
    use SoftDeletes;
    protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function members(){
        return $this->hasMany('App\Employee_group_member', 'employee_group_id', 'id');
    }
}
