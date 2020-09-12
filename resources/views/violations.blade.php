@extends('master')

@section('content')
<h2 class="content-heading">Dashboard of <span style="text-transform: uppercase; font-weight: bolder;color: blue;">{{ $employee->FullName }}</span></h2>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Violation List</h3>
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
                        @foreach($list as $data)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($data->date)->toFormattedDateString() }}</td>
                            <td>{{ $data->corrective->name }}</td>
                            <td class="text-center">
                                <a href="#view{{ $data->id }}" class="btn btn-primary btn-sm" data-toggle="modal"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                        <div class="modal fade" id="view{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-popout" role="document">
                                <div class="modal-content modal-lg">
                                    {!! Form::open(['method'=>'PATCH','action'=>['DashboardController@update_violation',$data->id]]) !!}
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
                                                        {!! Form::label('Memo From') !!}
                                                        {!! Form::text('admin_id',$data->admin->FullName,['class'=>'form-control']) !!}
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