@extends('master')

@section('content')
<h2 class="content-heading">Employee Corrective Module</h2>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Create Entry</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                {!! Form::open(['method'=>'POST','action'=>'EmployeecorrectiveController@store']) !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Date') !!}
                            <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="birthdate" disabled="" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                        </div>
                    </div>    
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::label('Select Employee/s') !!}
                            {!! Form::select('employee_id[]',$employees,null,['class'=>'js-select2 form-control','multiple','style'=>'width:100%;']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Select Corrective Level') !!}
                            {!! Form::select('corrective_level_id',$correctives,null,['class'=>'js-select2 form-control','placeholder'=>'PLEASE SELECT','style'=>'width:100%;']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Facts') !!}
                            {!! Form::textarea('facts',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Explanation') !!}
                            {!! Form::textarea('explanation',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Action Taken') !!}
                            {!! Form::textarea('action_taken',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                            <a href="{{ action('EmployeecorrectiveController@index') }}" class="btn btn-success"><i class="fa fa-home"></i> Back to Index</a>
                        </div>
                    </div>
                </div>    
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection