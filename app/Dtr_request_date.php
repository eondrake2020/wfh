<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dtr_request_date extends Model
{
    use SoftDeletes;
    protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function dtr(){
        return $this->belongsTo('App\Dtr_request','dtr_request_id','id');
    }
}
