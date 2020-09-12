@extends('master')

@section('content')
<h2 class="content-heading">Employee Corrective Module</h2>
<a href="{{ action('EmployeecorrectiveController@index') }}" class="btn btn-primary" style="margin-bottom: 10px;"><i class="fa fa-home"></i> Back to List
</a>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Employee Corrective Entries of {{ $employee->FullName }}</h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter data-table" id="table1">
                    <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Corrective Level</th>
                            <th class="text-center" width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employee->correctives as $data)
                        <td>{{ \Carbon\Carbon::parse($data->date)->toFormattedDateString() }}</td>
                        <td>
                            {{ $data->corrective->name }}
                            @if($data->explanation != NULL && $data->action_taken == NULL)
                            <span class="badge badge-primary">New Reply</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="#view{{ $data->id }}" class="btn btn-primary btn-sm" data-toggle="modal"><i class="fa fa-eye"></i></a>
                        </td>
                        <div class="modal fade" id="view{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-popout" role="document">
                                <div class="modal-content modal-lg">
                                    {!! Form::open(['method'=>'PATCH','action'=>['EmployeecorrectiveController@update_details',$data->id]]) !!}
                                    <div class="block block-themed">
                                        <div class="block-header bg-primary">
                                            <h3 class="block-title">View Details</h3>
                                            <div class="block-options">
                                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                    <i class="si si-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="block-content">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        {!! Form::label('Select Corrective Level') !!}
                                                        {!! Form::select('corrective_level_id',$correctives,$data->corrective_level_id,['class'=>'js-select2 form-control','placeholder'=>'PLEASE SELECT','style'=>'width:100%;']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {!! Form::label('Facts') !!}
                                                        {!! Form::textarea('facts',$data->facts,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {!! Form::label('Explanation') !!}
                                                        {!! Form::textarea('explanation',$data->explanation,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        {!! Form::label('Action Taken') !!}
                                                        {!! Form::textarea('action_taken',$data->action_taken,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Update
                                        </button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection