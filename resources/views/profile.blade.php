@extends('master')

@section('content')
<h2 class="content-heading">Dashboard of <span style="text-transform: uppercase; font-weight: bolder;color: blue;">{{ $employee->FullName }}</span></h2>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Update Employee Profile</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                {!! Form::model($employee,['method'=>'PATCH','action'=>['DashboardController@update_profile',$employee->id],'novalidate' => 'novalidate','files' => 'true']) !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Upload Image') !!}
                            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image">
                        </div>
                    </div>    
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Emp #') !!}
                            {!! Form::text('employee_number',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Select Campus') !!}
                            {!! Form::select('campus_id',$campuses,null,['class'=>'js-select2 form-control','placeholder'=>'PLEASE SELECT','style'=>'width:100%;']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Last Name') !!}
                            {!! Form::text('lastname',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('First Name') !!}
                            {!! Form::text('firstname',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('Middle Name') !!}
                            {!! Form::text('middlename',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            {!! Form::label('Ext') !!}
                            {!! Form::text('extname',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Select Gender') !!}
                            {!! Form::select('gender',['0'=>'MALE','1'=>'FEMALE'],null,['class'=>'js-select2 form-control','placeholder'=>'PLEASE SELECT','style'=>'width:100%;']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Contact Number') !!}
                            {!! Form::text('mobile',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Email Address') !!}
                            {!! Form::text('email',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>                        
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Birthdate') !!}
                            <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="birthdate" placeholder="" value="{{ \Carbon\Carbon::parse($employee->birthdate)->toDateString() }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Select Status') !!}
                            {!! Form::select('status',['REGULAR'=>'REGULAR','PROBATIONARY'=>'PROBATIONARY'],null,['class'=>'js-select2 form-control','placeholder'=>'PLEASE SELECT','style'=>'width:100%;']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Select Category') !!}
                            {!! Form::select('category',['ADMIN'=>'ADMIN','MEMBER'=>'MEMBER'],null,['class'=>'js-select2 form-control','placeholder'=>'PLEASE SELECT','style'=>'width:100%;']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Designation') !!}
                            {!! Form::text('designation',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                            <a href="{{ action('DashboardController@index') }}" class="btn btn-success"><i class="fa fa-home"></i> Back to Index</a>
                        </div>
                    </div>
                </div>    
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection