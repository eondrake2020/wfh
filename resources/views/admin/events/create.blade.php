@extends('master')

@section('content')
<h2 class="content-heading">Events Module</h2>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Create Event</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                {!! Form::open(['method'=>'POST','action'=>'EventController@store']) !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Date') !!}
                            <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                        </div>
                    </div>    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('Event Title') !!}
                            {!! Form::text('title',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('Event Description ') !!}
                            {!! Form::text('description',null,['class'=>'form-control']) !!}
                        </div>
                    </div>    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('Event Date From') !!}
                            <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="date_from" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('Event Date To') !!}
                            <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="date_to" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                            <a href="{{ action('EventController@index') }}" class="btn btn-success"><i class="fa fa-home"></i> Back to Index</a>
                        </div>
                    </div>
                </div>    
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection