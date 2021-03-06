@extends('master')

@section('content')
<h2 class="content-heading">Employee Module</h2>
<div class="row">
    <div class="col-md-4">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Create Employee Schedule for {{ $employee->FullName }}</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                {!! Form::open(['method'=>'POST','action'=>['EmployeeController@post_schedule',$employee->id]]) !!}
                    <div class="form-group">
                        {!! Form::label('Select Schedule Days') !!}
                        {!! Form::select('weekday_id[]',$weekdays,null,['class'=>'js-select2 form-control','style'=>'width:100%;','multiple']) !!}
                    </div>                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
