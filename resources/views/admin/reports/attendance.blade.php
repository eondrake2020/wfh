@extends('master')

@section('content')
<h2 class="content-heading">Reports Module</h2>
<div class="row">
    <div class="col-md-4">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Create Attendance Report</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                {!! Form::open(['method'=>'POST','action'=>'ReportController@print_attendance_report']) !!}
                    <div class="form-group">
                        {!! Form::label('Select Date From') !!}
                        <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="date_from">
                    </div>                    
                    <div class="form-group">
                        {!! Form::label('Select Date To') !!}
                        <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="date_to">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Generate Report</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection