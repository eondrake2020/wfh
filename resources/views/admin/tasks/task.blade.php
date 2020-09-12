@extends('master')

@section('content')
<h2 class="content-heading">Task Module</h2>
<a href="{{ action('DashboardController@index') }}" class="btn btn-primary" style="margin-bottom: 10px;"><i class="fa fa-home"></i> Back to Dashboard</a>
<div class="row">
    <div class="col-md-4">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Create Task Reply</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                {!! Form::open(['method'=>'POST','action'=>['DashboardController@post_task',$task->id]]) !!}
                <?php 
                    $checkTaskReply = \App\Task_reply::where('task_id',$task->id)
                        ->where('employee_id',Auth::user()->employee_id)
                        ->first();
                ?>
                <div class="form-group">
                    {!! Form::label('Date') !!}
                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="reply_date" value="{{ \Carbon\Carbon::now()->toDateString() }}" disabled="">
                </div>
                 <div class="form-group">
                    {!! Form::label('Task Reply') !!}
                    @if($checkTaskReply != NULL)
                    {!! Form::textarea('task_reply',$checkTaskReply->task_reply,['class'=>'form-control']) !!}
                    @else
                    {!! Form::textarea('task_reply',null,['class'=>'form-control']) !!}
                    @endif
                </div>                    
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">View Task</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Date') !!}
                            <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="date" value="{{ $task->date }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Select Task Type') !!}
                            {!! Form::select('task_type',['GROUP'=>'GROUP','INDIVIDUAL'=>'INDIVIDUAL'],$task->task_type,['class'=>'js-select2 form-control','placeholder'=>'PLEASE SELECT','style'=>'width:100%;','id'=>'type_id']) !!}
                        </div>
                    </div>    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('Task') !!}
                            {!! Form::textarea('task_details',$task->task_details,['class'=>'form-control','id'=>'summernote']) !!}
                        </div>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Date Started') !!}
                            <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="date_started" value="{{ $task->date_started }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Date Ended') !!}
                            <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="date_ended" value="{{ $task->date_ended }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Task Created By') !!}
                            {!! Form::text('name',$task->admin->FullName,['class'=>'form-control','readonly']) !!}
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>
@endsection