@extends('master')

@section('content')
<h2 class="content-heading">DTR Requests Module</h2>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">DTR Request List</h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter data-table" id="table1">
                    <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Employee</th>
                            <th class="text-center" width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $data)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($data->date)->toFormattedDateString() }}</td>
                            <td>{{ $data->employee->FullName }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                        <a href="{{ action('DashboardController@edit_dtr_request',$data->id) }}" class="dropdown-item"> View Request</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
