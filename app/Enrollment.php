<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
{
    use SoftDeletes;
    protected $guarded = [];
	protected $dates = ['deleted_at'];

	public function student(){
        return $this->belongsTo('App\Studentlist','student_id','id');
    }

    public function gradelevel(){
        return $this->belongsTo('App\Gradelevel','gradelevel_id','id');
    }

    public function campus(){
        return $this->belongsTo('App\Campus','campus_id','id');
    }

    public function strand(){
        return $this->belongsTo('App\Strand','strand_id','id');
    }

    public function sy(){
        return $this->belongsTo('App\Schoolyear','sy_id','id');
    }

    public function option(){
        return $this->belongsTo('App\Tuition_payment','option_id','id');
    }

    public function details(){
        return $this->hasMany('App\Enrollment_scheme', 'enrollment_id', 'id');
    }
}
