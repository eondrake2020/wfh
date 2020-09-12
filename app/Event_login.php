<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event_login extends Model
{
    use SoftDeletes;
    protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function eventdate(){
        return $this->belongsTo('App\Event_date','event_date_id','id');
    }

    public function employee(){
        return $this->belongsTo('App\Employee','employee_id','id');
    }
}
