<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee_corrective extends Model
{
    use SoftDeletes;
    protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function admin(){
        return $this->belongsTo('App\Employee','admin_id','id');
    }

    public function employee(){
        return $this->belongsTo('App\Employee','employee_id','id');
    }

    public function corrective(){
        return $this->belongsTo('App\Corrective_level','corrective_level_id','id');
    }
}
