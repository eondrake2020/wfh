@extends('master')

@section('content')
<h2 class="content-heading">Employee Corrective Module</h2>
<a href="{{ action('EmployeecorrectiveController@create') }}" class="btn btn-primary" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Create Memo</a>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Employee List</h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter data-table" id="table1">
                    <thead>
                        <tr>
                            <th class="text-center">Employee Name</th>
                            <th class="text-center" width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list->groupBy('employee_id') as $key => $value)
                        <tr>
                            <td>
                                {{ $value->first()->employee->FullName }}
                                @if($value->first()->explanation != NULL && $value->first()->action_taken == NULL)
                                <span class="badge badge-primary">New Reply</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ action('EmployeecorrectiveController@view_details',$value->first()->employee_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-list"></i></a>
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