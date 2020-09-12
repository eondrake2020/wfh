@extends('master')

@section('content')
<h2 class="content-heading">Task Module</h2>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Create Task</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                {!! Form::open(['method'=>'POST','action'=>'TaskController@store']) !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Date') !!}
                            <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                        </div>
                    </div>    
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Select Task Type') !!}
                            {!! Form::select('task_type',['GROUP'=>'GROUP','INDIVIDUAL'=>'INDIVIDUAL'],null,['class'=>'js-select2 form-control','placeholder'=>'PLEASE SELECT','style'=>'width:100%;','id'=>'type_id']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!! Form::label('', 'Select Participants: ') !!}
                            <select class="js-select2 form-control" name="member_id[]" id="combo_id" style="width: 100%;" multiple="multiple">
                            </select>
                        </div>
                    </div>    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('Create Task') !!}
                            {!! Form::textarea('task_details',null,['class'=>'form-control','id'=>'summernote']) !!}
                        </div>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Date Started') !!}
                            <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="date_started" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Date Ended') !!}
                            <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="date_ended" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Task Created By') !!}
                            {!! Form::text('name',$admin->FullName,['class'=>'form-control','readonly']) !!}
                            {!! Form::hidden('admin_id',$admin->id,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                            <a href="{{ action('TaskController@index') }}" class="btn btn-success"><i class="fa fa-home"></i> Back to Index</a>
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
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function ajax_getCombo() {
        var type_id = $('#type_id').val();
        
        $("#combo_id").html("");

        $.ajax({    
            type: 'GET',
            url: "{{ action('TaskController@getCombo') }}",     
            dataType: "json",    
            data: { 
                type_id:type_id,
            },
            success: function(response){
                $.each(response,function(index,value){
                    $("#combo_id").append('<option value="'+index+'">'+value+'</option>');
              
               });            
            }
        });
    }

    $(document).ready(function() {
        $("#combo_id").html("");        
        $('#type_id').change(ajax_getCombo);
    });
</script>
@endsection