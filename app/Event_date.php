<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event_date extends Model
{
    use SoftDeletes;
    protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function event(){
        return $this->belongsTo('App\Event','event_id','id');
    }

    public function logins(){
        return $this->hasMany('App\Employee_login', 'event_date_id', 'id');
    }
}
