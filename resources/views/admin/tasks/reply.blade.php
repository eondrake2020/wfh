@extends('master')

@section('content')
<h2 class="content-heading">Task Module</h2>
<a href="{{ action('DashboardController@view_task_replies',$task->id) }}" class="btn btn-primary" style="margin-bottom: 10px;"><i class="fa fa-home"></i> Back to Task Member List</a>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">View Reply of {{ $employee->FullName }}</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                @if($reply != NULL)
                {!! Form::open(['method'=>'POST','action'=>['DashboardController@post_reply',$task->id,$employee->id]]) !!}
                <div class="form-group">
                    {!! Form::label('Date') !!}
                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="reply_date" value="{{ \Carbon\Carbon::parse($reply->date)->toDateString() }}" disabled="">
                </div>
                 <div class="form-group">
                    {!! Form::textarea('task_reply',$reply->task_reply,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                        <div class="checkbox">
                            <label>
                                @if($reply->isApprove == 1)
                                <input type="checkbox" name="isApprove" value="1" checked="checked">
                                @else
                                <input type="checkbox" name="isApprove" value="1">
                                @endif Approve this Task?
                            </label>
                        </div>
                    </div>                   
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-approve"></i> Approve Reply</button>
                </div>
                {!! Form::close() !!}
                @else
                <h1 class="text-center">NO REPLY YET</h1>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection