@extends('master')

@section('content')
<h2 class="content-heading">DTR Request Module</h2>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Update DTR Request of {{ $dtr->employee->FullName }}</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                {!! Form::open(['method'=>'POST','action'=>['DashboardController@update_dtr_request',$dtr->id]]) !!}
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('Date') !!}
                                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-default" name="date" value="{{ $dtr->date }}" disabled="">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('Create DTR Request') !!}
                                    {!! Form::textarea('request',$dtr->request,['class'=>'form-control','id'=>'summernote']) !!}
                                </div>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Approve</button>
                                    <a href="{{ action('DashboardController@index') }}" class="btn btn-success"><i class="fa fa-home"></i> Back to Index</a>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-center">Requested Dates</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dtr->daterequests as $row)
                                <?php 
                                    $checkLogin = \App\Employee_login::where('employee_id',$dtr->employee_id)
                                        ->where('date',$row->date)
                                        ->first();
                                ?>
                                <tr>
                                    @if($checkLogin != NULL)
                                        @if($checkLogin->isApproved == 1)
                                        <td class="text-center"><input type="checkbox" name="dtr_request_id[]" value="{{ $row->date }}" checked="checked"></td>
                                        @else
                                        <td class="text-center"><input type="checkbox" name="dtr_request_id[]" value="{{ $row->date }}"></td>
                                        @endif
                                    @else
                                    <td class="text-center"><input type="checkbox" name="dtr_request_id[]" value="{{ $row->date }}"></td>
                                    @endif
                                    <td class="text-center">{{ \Carbon\Carbon::parse($row->date)->toFormattedDateString() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection