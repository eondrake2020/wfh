@extends('master')

@section('content')
<h2 class="content-heading">Task Module</h2>
<a href="{{ action('TaskController@create') }}" class="btn btn-primary" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Create Task</a>
<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary">
                <h3 class="block-title">Task List</h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter data-table">
                    <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Task Type</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Date Start</th>
                            <th class="text-center">Date End</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="100">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ action('TaskController@index') }}",
        columns: [
            {data: 'date', name: 'date'},
            {data: 'task_type', name: 'task_type'},
            {data: 'admin_id', name: 'admin_id'},
            {data: 'date_started', name: 'date_started'},
            {data: 'date_ended', name: 'date_ended'},
            {data: 'isClose', name: 'isClose'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@endsection