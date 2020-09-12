@extends('master')

@section('content')
<h2 class="content-heading">Employee Group Module</h2>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Create Employee Group</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                {!! Form::open(['method'=>'POST','action'=>'GroupController@store']) !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Group Name') !!}
                            {!! Form::text('name',null,['class'=>'form-control']) !!}
                        </div>
                    </div>    
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::label('Select Member(s)') !!}
                            {!! Form::select('employee_id[]',$employees,null,['class'=>'js-select2 form-control','multiple'=>'multiple','style'=>'width:100%;']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                            <a href="{{ action('GroupController@index') }}" class="btn btn-success"><i class="fa fa-home"></i> Back to Index</a>
                        </div>
                    </div>
                </div>    
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection