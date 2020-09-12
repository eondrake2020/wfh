@extends('master')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@section('content')
<h2 class="content-heading">DTR Request Module</h2>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Create DTR Request</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                {!! Form::open(['method'=>'POST','action'=>['DashboardController@post_dtr_request',$employee->id]]) !!}
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('Date') !!}
                            <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Select Admin') !!}
                            {!! Form::select('admin_id',$admins,null,['class'=>'js-select2 form-control','placeholder'=>'PLEASE SELECT','style'=>'width:100%;','id'=>'type_id']) !!}
                        </div>
                    </div>    
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('Select Inclusive Dates') !!}
                            {!! Form::text('inclusiveDates[]',null,['class'=>'form-control date']) !!}
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('Create DTR Request') !!}
                            {!! Form::textarea('request',null,['class'=>'form-control','id'=>'summernote']) !!}
                        </div>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
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
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $('.date').datepicker({
      multidate: true,
        format: 'yyyy-mm-dd',
    });
</script>
@endsection