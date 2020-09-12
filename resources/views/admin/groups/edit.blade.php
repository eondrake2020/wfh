@extends('master')

@section('content')
<h2 class="content-heading">Employee Group Module</h2>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Update Employee Group</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th width="80">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($group->members as $data)
                                <tr>
                                    <td>{{ $data->employee->FullName }}</td>
                                    <td class="text-center">
                                        <a href="{{ action('GroupController@delete_member',$data->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                {!! Form::model($group,['method'=>'PATCH','action'=>['GroupController@update',$group->id]]) !!}
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
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
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